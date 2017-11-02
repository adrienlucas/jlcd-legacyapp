.PHONY: test start

all: test start

start:
	php -S 0.0.0.0:8080

test:
	php test.php