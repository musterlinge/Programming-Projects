/* 	Sterling Johnson
    Z1944312
    CSCI-340-PE1

    I certify that this is my own work and where appropriate an extension
    of the starter code provided for the assignment.
*/


#ifndef BINARYSEARCHTREE_H_
#define BINARYSEARCHTREE_H_

#include "btree.h"
#include "node.h"
#include <iostream>

template <typename T>
class BinarySearchTree : public BinaryTree<T>
{
public:
    void Insert(const T& x);       // inserts node with value x
    bool Search(const T& x) const; // searches leaf with value x
    bool Remove(const T& x);       // removes leaf with value x
private:
    void _Insert(Node<T>*&, const T&);      // private version of insert
    bool _Search(Node<T>*, const T&) const; // private version of search
    void _Remove(Node<T>*&, const T&);      // private version of remove
    bool _Leaf(Node<T>* node) const;          // checks if node is leaf
};

/*Calls the private member _Insert to insert a value into the binary search tree
@param x the value that needs to be inserted
@note Will not insert duplicate values
*/
template <typename T>
void BinarySearchTree<T>::Insert(const T& x)      // inserts node with value x
{
    BinarySearchTree<T>::_Insert(this->root, x);

}

/*Searches if the value x is in the BST
@param x the value that needs to be searched for
@return will return a bool value, true if x found, false if x not found
*/
template <typename T>
bool BinarySearchTree<T>::Search(const T& x) const // searches leaf with value x
{
    return _Search(this->root, x);
}

/*Searches if the value x is in the BST
@param x the value that needs to be removed
@return will return a bool value, true if x removed, false if x not removed
*/
template <typename T>
bool BinarySearchTree<T>::Remove(const T& x)       // removes leaf with value x
{
    bool removed = false;
    if (Search(x))
    {
        _Remove(this->root, x);
        removed = true;
    }
    return removed;
}

/*Calls the private member _Insert to insert a value into the binary search tree
@param x the value that needs to be inserted
@param p the pointer to the root of the tree where the value should be inserted
@note Will not insert duplicate values
*/
template <typename T>
void BinarySearchTree<T>::_Insert(Node<T>*& p, const T& x)      // private version of insert
{
    if (p == nullptr)
    {
        p = new Node<T>(x);
    }
    else if (x < p->data)
    {
        _Insert(p->left, x);
    }
    else if (x > p->data)
    {
        _Insert(p->right, x);
    }

}

/*Searches if the value x is in the BST
@param x the value that needs to be searched for
@param p the pointer to the root of the tree where the value should be searched
@return will return a bool value, true if x found, false if x not found
*/
template <typename T>
bool BinarySearchTree<T>::_Search(Node<T>* p, const T& x) const // private version of search
{
    bool found = false;

    if (p == nullptr)
    {
        return found;
    }

    if (x < p->data)
    {
        _Search(p->left, x);
    }
    else if (x > p->data)
    {
        _Search(p->right, x);
    }
    else if (x == p->data)
    {
        found = true;
    }
    return found;
}

/*Searches if the value x is in the BST
@param x the value that needs to be removed
@param p the pointer to the root of the tree where the value should be removed
@return will return a bool value, true if x removed, false if x not removed
*/
template <typename T>
void BinarySearchTree<T>::_Remove(Node<T>*& p, const T& x)      // private version of remove
{

    //if p is nullptr, returns without attempting to delete
    if (p == nullptr)
    {
        return;
    }

    //
    if (x < p->data)
    {
        _Remove(p->left, x);
    }
    else if (x > p->data)
    {
        _Remove(p->right, x);
    }
    else
    {
        Node<T>* tempP = p;
        // Reattach the right child or nullptr
        if (_Leaf(p))
        {
            delete tempP;
            p = nullptr;
        }

        if (p->left == nullptr)
        {
            p = p->right;
            delete tempP;
        }
        // Reattach the left child or nullptr
        else if (p->right == nullptr)
        {
            p = p->left;
            delete tempP;
        }
        else
        {
            tempP = p->right;
            Node<T>* tempS = tempP;
            while (tempS && tempS->left != nullptr)
            {
                tempS = tempS->right;
            }
            tempP = tempS;
            p->data = tempP->data;
            _Remove(p->right, tempP->data);
        }
    }
}

template <typename T>
bool BinarySearchTree<T>::_Leaf(Node<T>* node) const
{
    bool leaf = false;
    if (node->right == nullptr && node->left == nullptr)
    {
        leaf = true;
    }

    return leaf;
}

#endif // End of BINARYSEARCHTREE_H_
