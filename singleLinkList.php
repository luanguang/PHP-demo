<?php

class Node
{
    public $data = null;
    public $next = null;

    public function __construct($data, $next = null)
    {
        $this->data = $data;
        $this->next = $next;
    }
}

class singleLinkList
{
    private $header = null;
    private $last = null;
    public $size = 0;

    public function add($data)
    {
        $node = new Node($data);
        if ($this->header == null and $this->last == null) {
            $this->header = $node;
            $this->last = $node;
        } else {
            $this->last->next = $node;
            $this->last = $node;
        }
    }

    public function del($data)
    {
        $node = $this->header;
        if ($node->data == $data) {
            $this->header = $this->header->next;
            return true;
        } else {
            while ($node->next->data == $data) {
                $node->next = $node->next->next;
                return true;
            }
        }
        return false;
    }

    public function update($old, $new)
    {
        $node = $this->header;
        while ($node->next != null) {
            if ($node->data == $old) {
                $node->data = $new;
                return true;
            }
            $node = $node->next;
        }
        echo 'not found!';
        return false;
    }

    public function find($data)
    {
        $node = $this->header;
        if ($node->data == $data) {
            echo 'found!';
            return true;
        }
        while ($node->next != null) {
            if ($node->data == $data) {
                echo 'found!';
                return true;
            }
            $node = $node->next;
        }
        echo 'not found!';
        return false;
    }

    public function getAll()
    {
        $node = $this->header;
        while ($node->next != null) {
            echo $node->data;
            $node = $node->next;
        }
        echo $node->data;
    }
}

$list = new singleLinkList();
$list->add('1');
$list->add('2');
$list->getAll();
$list->find('1');
