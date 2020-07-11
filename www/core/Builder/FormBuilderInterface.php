<?php

interface FormBuilderInterface
{
    public function add(string $name, string $type, array $options): self;

    public function remove(string $name): self;

    public function getElements(): ?array;
}