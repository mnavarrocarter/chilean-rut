coverage:
	vendor/bin/phpunit --coverage-text

cs:
	vendor/bin/php-cs-fixer fix --diff --verbose

commit: cs coverage
	git add . && git commit