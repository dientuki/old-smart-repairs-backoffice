#!/bin/bash

echo "Testing the die() on files"

if grep -E "(^|\ )die\(('|\")" -r --include=\*.php; then exit 1
fi

echo "Testing the dd() on files"

if grep -E "(^|\ )dd\(('|\")" -r --include=\*.php; then exit 1
fi

echo "Testing the var_dump() on files"

if grep -E "(^|\ )dd\(('|\")" -r --include=\*.php; then exit 1
fi

echo "Testing the print_r() on files"

if grep -E "(^|\ )print_r\(('|\")" -r --include=\*.php; then exit 1
fi