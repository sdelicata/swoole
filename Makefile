IMAGE=swoole

.PHONY: build
build:
	docker build --pull -t $(IMAGE) .