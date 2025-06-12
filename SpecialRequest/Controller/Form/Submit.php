<?php
namespace Anas\SpecialRequest\Controller\Form;

use Anas\SpecialRequest\Model\SpecialRequestFactory;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Psr\Log\LoggerInterface;
use Magento\Framework\Filesystem;
use Magento\Framework\App\Filesystem\DirectoryList; // ✅ Correct import
use Magento\MediaStorage\Model\File\UploaderFactory; // ✅ Correct uploader

class Submit extends Action
{
    protected $logger;
    protected $uploaderFactory;
    protected $filesystem;
    protected $specialRequestFactory;

    public function __construct(
        Context $context,
        LoggerInterface $logger,
        UploaderFactory $uploaderFactory,
        Filesystem $filesystem,
        SpecialRequestFactory $specialRequestFactory
    ) {
        $this->logger = $logger;
        $this->uploaderFactory = $uploaderFactory;
        $this->filesystem = $filesystem;
        $this->specialRequestFactory = $specialRequestFactory;
        parent::__construct($context);
    }
    

    public function execute()
    {
        $request = $this->getRequest();
        $full_name = $request->getParam('full_name');
        $email = $request->getParam('email');
        $phone = $request->getParam('phone');
        $entity_name = $request->getParam('entity_name');
        $special_req = $request->getParam('special_req');
        $fileName = 'No file uploaded';
        $filePath = '';
    
        // Handle file upload
        if (isset($_FILES['upload_file']) && $_FILES['upload_file']['name'] !== '') 
        {
            try {
                $uploader = $this->uploaderFactory->create(['fileId' => 'upload_file']);
                $uploader->setAllowedExtensions(['jpg', 'jpeg', 'png', 'pdf', 'docx']);
                $uploader->setAllowRenameFiles(true);
                $uploader->setFilesDispersion(false);
    
                $mediaDirectory = $this->filesystem->getDirectoryWrite(DirectoryList::MEDIA);
                $target = $mediaDirectory->getAbsolutePath('special_requests/');
                $result = $uploader->save($target);
                $fileName = $result['file'];
                $filePath = 'pub/media/special_requests/' . $fileName; // ✅ Relative path
    
            } catch (\Exception $e) {
                $this->logger->error('File Upload Error: ' . $e->getMessage());
            }
        }
    
        $logData = "Name: $full_name | Email: $email | Phone: $phone | Entity-Name: $entity_name | Special-Request: $special_req | Uploaded File: $fileName | File Path: $filePath";
        $writer = new \Zend_Log_Writer_Stream(BP . '/var/log/specialRequest.log');
        $logger = new \Zend_Log();
        $logger->addWriter($writer);
        $logger->info($logData);
       
        $requestModel = $this->specialRequestFactory->create();
        $requestModel->setData([
            'full_name'    => $full_name,
            'email'        => $email,
            'phone'        => $phone,
            'entity_name'  => $entity_name,
            'special_req'  => $special_req,
            'file_name'    => $fileName,
            'file_path'    => $filePath
        ]);
        $requestModel->save();

    
        $this->messageManager->addSuccessMessage(__('Your request was submitted.'));
        return $this->_redirect($this->_redirect->getRefererUrl());
    }
    
}
