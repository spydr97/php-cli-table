.PHONY: fix-phpcs test-phpcs

fix-phpcs:
	./vendor/bin/phpcbf --ignore=vendor --standard=spydr97  --extensions=php .

test-phpcs:
	./vendor/bin/phpcs --ignore=vendor --standard=spydr97  --extensions=php --colors .