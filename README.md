# AiPro Business Case Study Website

## Installation

1. Download the latest release from the releases page
2. Upload to your hosting and extract the archive to **/home/\<user\>/aipro-web** or any folder outside of the document root (public_html)
3. Extract **vendor.tar.gz**
4. Copy all files in **aipro-web/public** to the document root.
5. Open **public/index.php** using the file editor and do the following edit:

    * Change `__DIR__.'/../vendor/autoload.php'` to `__DIR__.'/../<aipro-web folder>/vendor/autoload.php'`
    * Change `__DIR__.'/../bootstrap/app.php'` to `__DIR__.'/../repositories/aipro-web/bootstrap/app.php'`

6. Copy **\<aipro-web folder\>/.env.example** to **\<aipro-web folder\>/.env**
7. Go to [keygen.io](https://keygen.io/ "Key Generator"), scroll down to "Laravel Encryption Key", click new and copy to clipboard.
8. Open **\<aipro-web folder\>/.env** using the file editor and do the following edit:

```
APP_NAME=<app name>
APP_ENV=local
APP_KEY=base64:<paste the encryption key here>
APP_DEBUG=true

APP_URL=<website url>

DB_HOST=<db host>
DB_PORT=<db port>
DB_DATABASE=<db name>
DB_USERNAME=<db user>
DB_PASSWORD=<db password>
```