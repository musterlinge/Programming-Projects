#ifndef H_BTREE
#define H_BTREE


#include "node.h"
#include <iostream>

typedef enum { left_side, right_side } SIDE;
SIDE rnd() {return rand() % 2 ? right_side : left_side;}// End of rnd()

template <typename T> class BinaryTree{

public:
    BinaryTree();                                      // default constructor
    unsigned int     getSize() const;                      // returns size of tree
    unsigned int    getHeight() const;                    // returns height of tree
    virtual void Insert(const T& val);                     // inserts node in tree
    void         Inorder(void (*f)(const T& val));          // inorder traversal of tree

protected:
    Node<T> *root;                                      // root of tree

private:
    unsigned int _getSize(Node<T> *p) const;                 // private version of getSize()
    unsigned int _getHeight(Node<T>* p) const;             // private version of getHeight()
    void     _Insert(Node<T>*& p, const T& val);           // private version of Insert()
    void     _Inorder(Node<T>* p, void (*f)(const T& val));   // private version of Inorder()
};

//constructor
template <typename T>
BinaryTree<T>::BinaryTree()
{
    root = nullptr;
}

//private member functions
template <typename T>
unsigned int BinaryTree<T>::_getSize(Node<T>* p) const
{
    if (!p)
    {
        return 0;
    }
    else
    {
        return(_getSize(p->left) + 1 + _getSize(p->right));
    }
}

template <typename T>
unsigned int BinaryTree<T>::_getHeight(Node<T>* p) const
{
    if (!p)
    {
        return 0;
    }
    int hLeft = _getHeight(p->left);
    int hRight = _getHeight(p->right);

    return (hLeft > hRight ? hLeft : hRight) + 1;
}

template <typename T>
void BinaryTree<T>::_Insert(Node<T>*& p, const T& val)
{
    if (!p)
    {
        p = new Node<T>(val);
        return;
    }

    auto side = rnd();
    if (side == left_side)
    {
        _Insert(p->left, val);
    }
    if (side == right_side)
    {
        _Insert(p->right, val);
    }
}

template <typename T>
void BinaryTree<T>::_Inorder(Node<T>* p, void (*f)(const T& val))
{
    if (!p)
    {
        return;
    }

    _Inorder(p->left, f);
    f(p->data);
    _Inorder(p->right, f);
}


//public member functions
template <typename T>
unsigned int BinaryTree<T>::getSize() const
{
    return _getSize(root);
}
template <typename T>
unsigned int BinaryTree<T>::getHeight() const
{
    return _getHeight(root);
}

template <typename T>
void BinaryTree<T>::Insert(const T& val)
{
    _Insert(root, val);
}

template <typename T>
void BinaryTree<T>::Inorder(void (*f)(const T& val))
{

   /* unsigned int h = getHeight();
    for (unsigned int i = 0; i <= h; ++i)
    {
        _Inorder(root->left, f);
        _Inorder(root->right, f);
    }
    */

    _Inorder(root, f);
}


#endif // End of H_BTREE


