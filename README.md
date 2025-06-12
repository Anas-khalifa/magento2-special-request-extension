# Magento 2 Special Request Form Extension

This Magento 2 extension provides a customizable form on the frontend where users can submit special requests. It supports file uploads and saves the data into a custom MySQL database table. Useful for government services, support requests, contact portals, or any business that needs to collect structured requests with attachments.

---

## 📦 Features

- ✅ Frontend special request form
- ✅ Fields: Full Name, Email, Phone, Entity Name, Special Request
- ✅ File upload (jpg, jpeg, png, pdf, docx)
- ✅ File saved to `pub/media/special_requests/`
- ✅ Data stored in custom MySQL table `anas_special_request`
- ✅ Log file records all submissions
- ✅ Custom frontend route: `/specialrequest/form`

---

## 🛠️ Installation

1. Copy the extension to your Magento app code folder:

2. Enable the module:
```bash
php bin/magento module:enable Anas_SpecialRequest --Change Your Company Name "Anas"
php bin/magento setup:upgrade
php bin/magento cache:flush

3. Make sure the media directory is writable after you create them:
mkdir -p pub/media/special_requests
chmod -R 777 pub/media/special_requests

-The databasey will be created automatically using MySQL so don't worry.-

Thats it.
Enjoy
