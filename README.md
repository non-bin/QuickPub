# QuickPub v0.1.0-alpha

## Notes THIS FILE IS NOT UP TO DATE!

File uploading and probably lots of other things do not work in this version

## Getting Started

### Prerequisites
To get this version of QuickPub working you will need a web server with php 5 or up. For simplicity I'm going to assume that anyone who is using QuickPub at this point knows what they're doing, and has a web server already installed.

### Installing

Clone the repository with git:
`git clone https://github.com/hazzdood/QuickPub.git`

Or download though your browser:
[https://codeload.github.com/hazzdood/QuickPub/zip/master](https://codeload.github.com/hazzdood/QuickPub/zip/master)

Copy the contents of the `QuickPub` directory to your web server, In a production environment only the www directory should be accessible from the web.

Import `QuickPub.sql` to your mysql server and change lines 3-6 of `QiockPub/managers/mysql.php` to match your server, the user should *only* have `select`, `create` and `modify` privileges.

### Troubleshooting

I really don't know, google it?
