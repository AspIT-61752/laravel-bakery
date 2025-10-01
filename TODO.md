How to deploy.

Set subpage root folder to /public/
run these commands in the root dir, and make sure that the storage file points to the right dir.
`composer install --no-dev --optimize-autoloader`
`php artisan key:generate`
`php artisan migrate`
`php artisan storage:link`
`php artisan config:cache`
`php artisan route:cache`
`php artisan view:cache`

and remember to add a default picture to the public/default folder. The default PFP is pear.png
