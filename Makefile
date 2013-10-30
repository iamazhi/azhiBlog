VERSION=$(shell head -n 1 VERSION)

all: tgz
linux: tgz build4linux

clean:
	rm -fr chanzhieps
	rm -fr *.tar.gz
	rm -fr *.zip
tgz:
	mkdir chanzhieps
	cp -frv system chanzhieps/
	rm -fr chanzhieps/system/config/my.php
	cp -frv www chanzhieps && rm -fr chanzhieps/www/data/* && mkdir -p chanzhieps/www/data/upload/
	rm -frv chanzhieps/system/tmp/cache/* 
	rm -frv chanzhieps/system/tmp/extension/*
	rm -frv chanzhieps/system/tmp/log/*
	rm -frv chanzhieps/system/tmp/model/*
	# combine js and css files.
	mkdir -pv chanzhieps/system/build/ && cp system/build/minifyfront.php chanzhieps/system/build/
	cd chanzhieps/system/build/ && php ./minifyfront.php
	rm -frv chanzhieps/system/build
	# delee the unused files.
	find chanzhieps -name .git* |xargs rm -frv
	find chanzhieps -name tests |xargs rm -frv
	# change mode.
	chmod 777 -R chanzhieps/system/tmp/
	chmod 777 -R chanzhieps/www/data
	chmod 777 -R chanzhieps/system/config
	chmod 777 chanzhieps/system/module
	chmod a+rx chanzhieps/system/bin/*
	#find chanzhieps/ -name ext |xargs chmod 777 -R
	# zip it.
	zip -r -9 chanzhiEPS.$(VERSION).zip chanzhieps
	rm -fr chanzhieps
ips:
	mkdir chanzhiips
	cp -frv system chanzhiips/
	rm -fr chanzhiips/system/config/my.php
	cp -frv www chanzhiips && rm -fr chanzhiips/www/data/* && mkdir -p chanzhiips/www/data/upload/
	rm -frv chanzhiips/system/tmp/cache/* 
	rm -frv chanzhiips/system/tmp/extension/*
	rm -frv chanzhiips/system/tmp/log/*
	rm -frv chanzhiips/system/tmp/model/*
	# combine js and css files.
	mkdir -pv chanzhiips/system/build/ && cp system/build/minifyfront.php chanzhiips/system/build/
	cd chanzhiips/system/build/ && php ./minifyfront.php
	rm -frv chanzhiips/system/build
	# merge chanzhiips
	git clone git@github.com:xirang/chanzhiips.git ips
	rsync -av --exclude='db/' --exclude='.git/' --exclude='README.md' ips/ chanzhiips
	cat ips/system/db/install.sql >> chanzhiips/system/db/chanzhi.sql
	# delete the unused files.
	find chanzhiips -name .git* |xargs rm -frv
	find chanzhiips -name tests |xargs rm -frv
	cd chanzhiips/system/module && rm -frv rss product blog forum help reply thread comment
	# change mode.
	chmod 777 -R chanzhiips/system/tmp/
	chmod 777 -R chanzhiips/www/data
	chmod 777 -R chanzhiips/system/config
	chmod 777 chanzhiips/system/module
	chmod a+rx chanzhiips/system/bin/*
	# zip it.
	zip -r -9 chanzhiIPS.$(VERSION).zip chanzhiips
	rm -fr chanzhiips
	rm -fr ips
