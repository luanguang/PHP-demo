<?php

class tree
{
    public $data;
    public $left = null;
    public $right = null;

    public function __construct($data)
    {
        $this->data = $data;
    }

    //先序遍历 (DLR) 根左右 preOrder
    public function preOrder()
    {
        echo $this->data . ' ';
        if ($this->left) {
            $this->left->preOrder();
        }
        if ($this->right) {
            $this->right->preOrder();
        }
    }

    //中序遍历 (LDR) 左根右 inOrder
    public function inOrder()
    {
        if ($this->left) {
            $this->left->inOrder();
        }
        echo $this->data . ' ';
        if ($this->right) {
            $this->right->inOrder();
        }
    }

    //后序遍历 (LRD) 左右根 postOrder
    public function postOrder()
    {
        if ($this->left) {
            $this->left->postOrder();
        }
        if ($this->right) {
            $this->right->postOrder();
        }
        echo $this->data . ' ';
    }
}

$trees = new tree(8);
$trees->left = new tree(3);
$trees->left->left = new tree(1);
$trees->left->right = new tree(6);
$trees->left->right->left = new tree(4);
$trees->left->right->right = new tree(7);

$trees->right = new tree(10);
$trees->right->right = new tree(14);
$trees->right->right->left = new tree(13);

echo '<pre>';
$trees->preOrder();
echo '<br>';
$trees->inOrder();
echo '<br>';
$trees->postOrder();
echo '<br>';