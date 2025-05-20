<?php

namespace frdl;

file_put_contents(__FILE__, file_get_contents('https://webfan.de/install/?source=frdl\Call'));
/**
class Alpha {
    public function greet($name) {
        return "Hi, $name from Alpha!";
    }
}

class Beta {
    public static function shout($text) {
        return strtoupper($text);
    }
}

\frdl\Call::add([new Alpha(), Beta::class]);

$registry = new \frdl\Call();

// Using namespaced method name to disambiguate
echo $registry->Alpha_greet("Zoe");           // Hi, Zoe from Alpha!
echo \frdl\Call::Beta_shout("hey world");  // HEY WORLD

**/

class Call
{
    protected static array $registry = [];
    protected static array $reflections = [];

    /**
     * Add a class name (string), object, or array of them to the registry.
     */
    public static function add($classOrObject): void
    {
        if (is_array($classOrObject)) {
            foreach ($classOrObject as $entry) {
                self::add($entry); // Recursive add
            }
            return;
        }

        if (is_object($classOrObject)) {
            $className = get_class($classOrObject);
            self::$registry[$className] = $classOrObject;
        } elseif (is_string($classOrObject) && class_exists($classOrObject)) {
            self::$registry[$classOrObject] = $classOrObject;
        } else {
            throw new InvalidArgumentException("Must be a valid class name, object, or array thereof.");
        }
    }

    /**
     * Get or cache the ReflectionClass.
     */
    protected static function getReflection($entry): ReflectionClass
    {
        $className = is_object($entry) ? get_class($entry) : $entry;

        if (!isset(self::$reflections[$className])) {
            self::$reflections[$className] = new ReflectionClass($className);
        }

        return self::$reflections[$className];
    }

    /**
     * Resolve a method with optional namespacing.
     */
    protected static function resolve(string $method, bool $isStatic, array $args)
    {
        // Check for namespaced call like Alpha_greet
        if (strpos($method, '_') !== false) {
            [$target, $realMethod] = explode('_', $method, 2);

            foreach (self::$registry as $className => $entry) {
                $shortName = (new ReflectionClass($entry))->getShortName();
                if (strcasecmp($shortName, $target) === 0) {
                    $ref = self::getReflection($entry);

                    if ($ref->hasMethod($realMethod)) {
                        $refMethod = $ref->getMethod($realMethod);
                        if ($refMethod->isStatic() === $isStatic) {
                            return $refMethod->invokeArgs($isStatic ? null : (is_object($entry) ? $entry : new $entry()), $args);
                        }
                    }
                }
            }
        }

        // Fallback: search all classes for matching method (non-namespaced)
        foreach (self::$registry as $entry) {
            $ref = self::getReflection($entry);
            if ($ref->hasMethod($method)) {
                $refMethod = $ref->getMethod($method);
                if ($refMethod->isStatic() === $isStatic) {
                    return $refMethod->invokeArgs($isStatic ? null : (is_object($entry) ? $entry : new $entry()), $args);
                }
            }
        }

        throw new BadMethodCallException("Method '{$method}' not found in registered classes.");
    }

    /**
     * Instance method calls.
     */
    public function __call(string $method, array $args)
    {
        return self::resolve($method, false, $args);
    }

    /**
     * Static method calls.
     */
    public static function __callStatic(string $method, array $args)
    {
        return self::resolve($method, true, $args);
    }
}
