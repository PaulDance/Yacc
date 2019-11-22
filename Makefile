
assetsDir = ./public/assets
imgDir = $(assetsDir)/img
roomImgDir = $(imgDir)/room
regionImgDir = $(imgDir)/region

dbPath = ./var/data.db
tmpDir = ./tmp
logDir = ./var/log


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
	@./bin/console cache:clear --no-warmup -vv

.PHONY: clean-all
clean-all: clean
	@set -e
	rm -rf $(roomImgDir)/*
	rm -rf $(regionImgDir)/*
	rm -f $(dbPath)
