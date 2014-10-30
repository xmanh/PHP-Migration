<?php
namespace PhpMigration;

/*
 * @author Yuchen Wang <phobosw@gmail.com>
 *
 * Code is compliant with PSR-1 and PSR-2 standards
 * http://www.php-fig.org/psr/psr-1/
 * http://www.php-fig.org/psr/psr-2/
 */

class SymbolTable
{
    const CS = true;
    const IC = false;

    protected $caseSensitive;

    protected $data;

    public function __construct($data, $case_sensitive = true)
    {
        $this->data = array();
        foreach ($data as $rawkey => $value) {
            $key = $case_sensitive ? $rawkey : strtolower($rawkey);
            $this->data[$key] = $value;
        }
        $this->caseSensitive = $case_sensitive;
    }

    public function has($key)
    {
        // Compatible with almost all type key
        if (!is_string($key) && !method_exists($key, '__toString')) {
            return false;
        }

        $key = $this->caseSensitive ? $key : strtolower($key);
        return isset($this->data[$key]);
    }

    public function get($key)
    {
        $key = $this->caseSensitive ? $key : strtolower($key);
        return isset($this->data[$key]) ? $this->data[$key] : null;
    }

    public function set($key, $value)
    {
        $key = $this->caseSensitive ? $key : strtolower($key);
        return $this->data[$key] = $value;
    }
}