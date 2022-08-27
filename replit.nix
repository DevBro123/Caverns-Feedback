{ pkgs }: {
    deps = [
        pkgs.nodejs-16_x
        pkgs.php80
        pkgs.php80Packages.composer
        pkgs.apacheHttpd
    ];
}