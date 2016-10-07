### Doubly Linked List usage

```php
use PHPds\LinkedList\LinkedList;
use PHPds\LinkedList\LinkedListInterface;

// Create a LinkedList
$list = new LinkedList();

// Insert a Node (head)
$node = $list->insert($nodeData);

// Insert a Node (tail)
$node = $list->insert($nodeData, LinkedListInterface::LAST);

// Insert a Node (using an index, which can be only integers in the range 0..listSize)
$node = $list->insertAt($index, $nodeData);

// Remove (head)
$list->remove();

// Remove (tail)
$list->remove(LinkedListInterface::LAST);

// Remove Node (passing a NodeInterface instance)
$list->removeNode($node);

// Search (strict) for Nodes containing certain data
$nodes = $list->search($nodeData);

// Check if a NodeInterface instance is in the LinkedList
if ($list->has($node)) {
    ...
}

// Get a Node at a certain index (0..listSize)
$node = $list->get($index);

// Pop head (get the head Node and remove it from the list)
$node = $list->pop();

// Pop tail (get the tail Node and remove it from the list)
$node = $list->pop(LinkedListInterface::LAST);

// Peek head (get the head Node without removing it from the List)
$node = $list->peek();

// Peek tail (get the tail Node without removing it from the List)
$node = $list->peek(LinkedListInterface::LAST);

// Get the list size
$size = $list->count();
```
LinkedList can be used as an array, using the `LinkedListArray`, which implements the `ArrayAccess` and `Iterator` interfaces:

```php
use PHPds\LinkedList\LinkedList;
use PHPds\LinkedList\LinkedListArray;

$list = new LinkedList();
$arrayList = new LinkedListArray($list);
$arrayList->offsetSet($index, $nodeData);
$arrayList->offsetGet($index);
$arrayList->offsetExists($index);
$arrayList->offsetUnset($index);

// Access Nodes using keys
$node = $arrayList[0];

// Iterate over the list
// Take into consideration that the default elements order
// is the reversed order on which they were added to the list.
// This is the preferred behavior for LinkedList, since
// insertion at the beginning is done in O(1) time complexity.
$list = new LinkedList();
$node1 = $list->insert($nodeData);
$node2 = $list->insert($nodeData);
$node3 = $list->insert($nodeData);
foreach ($arrayList as $node {
    // $node3, $node2, $node1
} 

```
