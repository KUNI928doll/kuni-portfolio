#!/bin/bash
# SCSS を assets/css へコンパイル
cd "$(dirname "$0")"
sass --load-path=sass --no-source-map --style=expanded sass/style.scss assets/css/style.css "$@"
