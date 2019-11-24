
assetsDir = ./public/assets
imgDir = $(assetsDir)/img
roomImgDir = $(imgDir)/room
regionImgDir = $(imgDir)/region

dbPath = ./var/data.db
tmpDir = ./tmp
logDir = ./var/log
cacheDir = ./var/cache


.PHONY: install
install: init
	@set -e
	@composer install -vv
	@composer clear-cache -vv
	@./bin/console assets:install -vv

.PHONY: run
run: clean
	@set -e
	@./bin/console server:run -vvv


.PHONY: init
init:
	@set -e
	@mkdir -v -p -m=755 $(tmpDir)
	@mkdir -v -p -m=755 $(roomImgDir)
	@mkdir -v -p -m=755 $(regionImgDir)


.PHONY: db
db: clean-all init
	@set -e
	@./bin/console doctrine:database:create -vv
	@./bin/console doctrine:schema:create -vv
	@./bin/console doctrine:fixtures:load -n -vv

.PHONY: clean
clean:
	@set -e
	rm -rf $(tmpDir)/*
	rm -rf $(logDir)/*
	rm -rf $(cacheDir)/*

.PHONY: clean-all
clean-all: clean
	@set -e
	rm -rf $(roomImgDir)/*
	rm -rf $(regionImgDir)/*
	rm -f $(dbPath)

