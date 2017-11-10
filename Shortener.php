<?php

class Shortener {

    public  $db;
    protected static $instance;


    public function __construct()
    {
        $this->db = new mysqli('localhost', 'admin', 'admin', 'shorturl');
    }

    /**
     * singleton
     *
     * @return Shortener
     */
    public static function getInstance()
    {
        if(self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * создаем алиас.
     *
     * @param $url
     * @return string
     */
    public function createAlias($url)
    {
        if(!filter_var($url, FILTER_VALIDATE_URL)) {
            return '';
        }

        $url = $this->db->escape_string($url);

        $exists = $this->db->query("SELECT alias FROM links WHERE url = '{$url}'");

        if($exists->num_rows) {
            return $exists->fetch_object()->alias;
        } else {
            // вставляем запись без алиаса
            $this->db->query("INSERT INTO links (url, created) VALUES ('{$url}', NOW())");

            // генерируем алиас
            $alias = $this->generateCode($this->db->insert_id);

            // обновляем запись в БД
            $this->db->query("UPDATE links SET alias = '{$alias}' WHERE url = '{$url}'");

            return $alias;
        }
    }

    /**
     * проверяем алиас на существование
     *
     * @param $userAlias
     * @param $url
     * @return bool|string
     */
    public function checkAlias($userAlias, $url)
    {
        $userAlias = $this->db->escape_string($userAlias);
        $exists = $this->db->query("SELECT alias FROM links WHERE alias = '{$userAlias}'");

        if($exists->num_rows) {
            return false;
        } else {
            $existsUrl = $this->db->query("SELECT url FROM links WHERE url = '{$url}'");
            if($existsUrl->num_rows) {
                return false;
            } else {
                $this->db->query("INSERT INTO links (url, created) VALUES ('{$url}', NOW())");
                $this->db->query("UPDATE links SET alias = '{$userAlias}' WHERE url = '{$url}'");
                return $userAlias;
            }
        }
    }

    /**
     * получаем url по алиасу
     *
     * @param $alias
     * @return string
     */
    public function getUrl($alias)
    {
        $alias = $this->db->escape_string($alias);
        $url = $this->db->query("SELECT url FROM links WHERE alias = '{$alias}'");
        if($url->num_rows) {
            return $url->fetch_object()->url;
        }

        return '';
    }

    /**
     * генерируем число
     *
     * @param $num
     * @return string
     */
    protected function generateCode($num)
    {
        return substr(md5($num), 0, 5);
    }

    /**
     * очищаем данные
     *
     * @param $value
     * @return string
     */
    public function cleanInput($value)
    {
        $value = trim($value);
        $value = stripslashes($value);
        $value = strip_tags($value);
        $value = htmlspecialchars($value);
        return $value;
    }
}

