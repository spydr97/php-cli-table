.PHONY: fix-phpcs test-phpcs

fix-phpcs:
	php composer.phar run-script fix-phpcs

test-phpcs:
	php composer.phar run-script test-phpcs
