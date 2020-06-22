<?php

interface ElementFormBuilderInterface
{
    public function setName(string $name): self;
    
    public function getName(): string;

    public function setType(string $type): self;

    public function getType(): string;

    public function setOptions(array $options): self;

    public function getOptions(): array;
}