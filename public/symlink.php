<?php
symlink(
    __DIR__.'/storage/app/public',
    __DIR__.'/public/storage'
);
echo "Symlink created! Delete this file now.";