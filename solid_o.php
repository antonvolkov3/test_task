<?php
interface Handler {
    public function handle(SomeObject $object): void;
    public function canHandle(SomeObject $object): bool;
}

class Object1Handler implements Handler {
    public function handle(SomeObject $object): void {
        // Обработка объекта типа object_1
    }

    public function canHandle(SomeObject $object): bool {
        return $object->getObjectName() === 'object_1';
    }
}

class Object2Handler implements Handler {
    public function handle(SomeObject $object): void {
        // Обработка объекта типа object_2
    }

    public function canHandle(SomeObject $object): bool {
        return $object->getObjectName() === 'object_2';
    }
}

class SomeObject {
    protected string $name;

    public function __construct(string $name) {
        $this->name = $name;
    }

    public function getObjectName() {
        return $this->name;
    }
}

class SomeObjectsHandler {
    private array $handlers = [];

    public function addHandler(Handler $handler): void {
        $this->handlers[] = $handler;
    }

    public function handleObjects(array $objects): void {
        foreach ($objects as $object) {
            foreach ($this->handlers as $handler) {
                if ($handler->canHandle($object)) {
                    $handler->handle($object);
                    break;
                }
            }
        }
    }
}

$objects = [
    new SomeObject('object_1'),
    new SomeObject('object_2')
];

$soh = new SomeObjectsHandler();
$soh->addHandler(new Object1Handler());
$soh->addHandler(new Object2Handler());
$soh->handleObjects($objects);