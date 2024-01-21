/* 	Sterling Johnson
    Z1944312
    CSCI-340-PE1

    I certify that this is my own work and where appropriate an extension
    of the starter code provided for the assignment.
*/


#ifndef STACK_H
#define STACK_H
#include <queue>

template<typename T>
class Stack
{
private:
	std::queue<T> q1;	// These queues are where the stack's elements 
	std::queue<T> q2;	// are to be saved.

public:
	bool empty() const;
	int size() const;
	const T& top();
	void push(const T& val);
	void pop();
};


// Note that the members of a template go into a .h file since 
// they are not compiled directly into a .o file like the members 
// of regular/non-template classes.



/* Determines if queue is empty
@returns true if the queue is empty, returns false if it is not empty
*/
template<typename T> bool Stack<T>::empty() const
{
	return q1.empty();
}

/*determines the size of the queue
@returns the size of the queue
*/
template<typename T> int Stack<T>::size() const
{
	return q1.size();
}

/* provides the last element in q1
@returns the last element in q1, which is the top of a stack
*/
template<typename T> const T& Stack<T>::top()
{

	return q1.front();

}

//Adds an element to the end of the queue, which is the top of the stack
template<typename T> void Stack<T>::push(const T& val)
{
	q1.push(val);
}

// Removes an element from the top of the stack
template<typename T> void Stack<T>::pop()
{
	if (q1.empty())
	{
		return;
	}
	while (q1.size() != 1)
	{
		q2.push(q1.front());
		q1.pop();
	}

	//empty q1
	q1.pop();

	//replace elements back into queue named q1
	std::queue<T> q3 = q1;
	q1 = q2;
	q2 = q3;
}



#endif // STACK_H
