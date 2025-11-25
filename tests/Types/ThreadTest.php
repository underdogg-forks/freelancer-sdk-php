<?php

declare(strict_types=1);

namespace FreelancerSdk\Tests\Types;

use FreelancerSdk\Types\Thread;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

/**
 * Comprehensive unit tests for the Thread model class.
 */
class ThreadTest extends TestCase
{
    /**
     * Test that a Thread can be instantiated with an empty array.
     */
    #[Test]
    public function it_can_instantiate_with_empty_array(): void
    {
        $thread = new Thread([]);
        
        $this->assertInstanceOf(Thread::class, $thread);
        $this->assertNull($thread->getId());
        $this->assertNull($thread->getOwner());
        $this->assertNull($thread->getThreadType());
    }

    /**
     * Test that a Thread can be instantiated with declared properties.
     */
    #[Test]
    public function it_can_instantiate_with_declared_properties(): void
    {
        $data = [
            'id' => 12345,
            'thread' => ['message_count' => 5],
            'context' => ['project_id' => 67890],
            'members' => [111, 222, 333],
            'owner' => 111,
            'thread_type' => 'private_chat',
            'time_created' => 1640000000,
        ];

        $thread = new Thread($data);

        $this->assertSame(12345, $thread->getId());
        $this->assertSame(['message_count' => 5], $thread->getThread());
        $this->assertSame(['project_id' => 67890], $thread->getContext());
        $this->assertSame([111, 222, 333], $thread->getMembers());
        $this->assertSame(111, $thread->getOwner());
        $this->assertSame('private_chat', $thread->getThreadType());
        $this->assertSame(1640000000, $thread->getTimeCreated());
    }

    /**
     * Test that undeclared properties are stored in attributes.
     */
    #[Test]
    public function it_undeclared_properties_stored_in_attributes(): void
    {
        $data = [
            'id' => 123,
            'custom_field' => 'custom_value',
            'metadata' => ['key' => 'value'],
        ];

        $thread = new Thread($data);

        $this->assertSame(123, $thread->getId());
        $this->assertSame('custom_value', $thread->getAttribute('custom_field'));
        $this->assertSame(['key' => 'value'], $thread->getAttribute('metadata'));
    }

    /**
     * Test getAttribute with default value when attribute doesn't exist.
     */
    #[Test]
    public function it_get_attribute_returns_default_when_not_set(): void
    {
        $thread = new Thread([]);

        $this->assertNull($thread->getAttribute('nonexistent'));
        $this->assertSame('default', $thread->getAttribute('nonexistent', 'default'));
        $this->assertSame([], $thread->getAttribute('nonexistent', []));
    }

    /**
     * Test the fill method updates existing properties.
     */
    #[Test]
    public function it_fill_method_updates_properties(): void
    {
        $thread = new Thread(['id' => 1, 'owner' => 100]);

        $this->assertSame(1, $thread->getId());
        $this->assertSame(100, $thread->getOwner());

        $thread->fill(['id' => 2, 'owner' => 200, 'thread_type' => 'group']);

        $this->assertSame(2, $thread->getId());
        $this->assertSame(200, $thread->getOwner());
        $this->assertSame('group', $thread->getThreadType());
    }

    /**
     * Test the fill method returns the instance for method chaining.
     */
    #[Test]
    public function it_fill_method_returns_instance(): void
    {
        $thread = new Thread([]);
        $result = $thread->fill(['id' => 123]);

        $this->assertSame($thread, $result);
    }

    /**
     * Test toArray includes all non-null properties.
     */
    #[Test]
    public function it_to_array_includes_non_null_properties(): void
    {
        $data = [
            'id' => 999,
            'owner' => 888,
            'thread_type' => 'project',
        ];

        $thread = new Thread($data);
        $array = $thread->toArray();

        $this->assertArrayHasKey('id', $array);
        $this->assertArrayHasKey('owner', $array);
        $this->assertArrayHasKey('thread_type', $array);
        $this->assertSame(999, $array['id']);
        $this->assertSame(888, $array['owner']);
        $this->assertSame('project', $array['thread_type']);
    }

    /**
     * Test toArray excludes null properties.
     */
    #[Test]
    public function it_to_array_excludes_null_properties(): void
    {
        $thread = new Thread(['id' => 123]);
        $array = $thread->toArray();

        $this->assertArrayHasKey('id', $array);
        $this->assertArrayNotHasKey('owner', $array);
        $this->assertArrayNotHasKey('thread_type', $array);
        $this->assertArrayNotHasKey('members', $array);
    }

    /**
     * Test toArray merges attributes into the result.
     */
    #[Test]
    public function it_to_array_merges_attributes(): void
    {
        $data = [
            'id' => 456,
            'custom_attr' => 'value',
            'flags' => ['read' => true],
        ];

        $thread = new Thread($data);
        $array = $thread->toArray();

        $this->assertArrayHasKey('id', $array);
        $this->assertArrayHasKey('custom_attr', $array);
        $this->assertArrayHasKey('flags', $array);
        $this->assertSame('value', $array['custom_attr']);
        $this->assertSame(['read' => true], $array['flags']);
    }

    /**
     * Test jsonSerialize returns the same as toArray.
     */
    #[Test]
    public function it_json_serialize_returns_array_representation(): void
    {
        $data = [
            'id' => 789,
            'owner' => 456,
            'custom' => 'data',
        ];

        $thread = new Thread($data);

        $this->assertSame($thread->toArray(), $thread->jsonSerialize());
    }

    /**
     * Test that Thread can be JSON encoded.
     */
    #[Test]
    public function it_thread_can_be_json_encoded(): void
    {
        $thread = new Thread(['id' => 100, 'owner' => 50]);
        $json = json_encode($thread);

        $this->assertIsString($json);
        $decoded = json_decode($json, true);
        $this->assertSame(100, $decoded['id']);
        $this->assertSame(50, $decoded['owner']);
    }

    /**
     * Test ArrayAccess offsetExists with declared properties.
     */
    #[Test]
    public function it_offset_exists_with_declared_properties(): void
    {
        $thread = new Thread(['id' => 123, 'owner' => 100]);

        $this->assertTrue(isset($thread['id']));
        $this->assertTrue(isset($thread['owner']));
        $this->assertFalse(isset($thread['nonexistent']));
    }

    /**
     * Test ArrayAccess offsetExists with attributes.
     */
    #[Test]
    public function it_offset_exists_with_attributes(): void
    {
        $thread = new Thread(['custom_field' => 'value']);

        $this->assertTrue(isset($thread['custom_field']));
    }

    /**
     * Test ArrayAccess offsetGet with declared properties.
     */
    #[Test]
    public function it_offset_get_with_declared_properties(): void
    {
        $thread = new Thread(['id' => 555, 'owner' => 75]);

        $this->assertSame(555, $thread['id']);
        $this->assertSame(75, $thread['owner']);
    }

    /**
     * Test ArrayAccess offsetGet with attributes.
     */
    #[Test]
    public function it_offset_get_with_attributes(): void
    {
        $thread = new Thread(['custom' => 'attribute']);

        $this->assertSame('attribute', $thread['custom']);
    }

    /**
     * Test ArrayAccess offsetGet returns null for nonexistent keys.
     */
    #[Test]
    public function it_offset_get_returns_null_for_nonexistent(): void
    {
        $thread = new Thread([]);

        $this->assertNull($thread['nonexistent']);
    }

    /**
     * Test ArrayAccess offsetSet with declared properties.
     */
    #[Test]
    public function it_offset_set_with_declared_properties(): void
    {
        $thread = new Thread([]);
        $thread['id'] = 777;
        $thread['owner'] = 99;

        $this->assertSame(777, $thread->getId());
        $this->assertSame(99, $thread->getOwner());
    }

    /**
     * Test ArrayAccess offsetSet with attributes.
     */
    #[Test]
    public function it_offset_set_with_attributes(): void
    {
        $thread = new Thread([]);
        $thread['custom'] = 'new_value';

        $this->assertSame('new_value', $thread->getAttribute('custom'));
    }

    /**
     * Test ArrayAccess offsetUnset with declared properties sets them to null.
     */
    #[Test]
    public function it_offset_unset_with_declared_properties_sets_to_null(): void
    {
        $thread = new Thread(['id' => 123, 'owner' => 50]);

        unset($thread['id']);

        $this->assertNull($thread->getId());
        $this->assertSame(50, $thread->getOwner());
    }

    /**
     * Test ArrayAccess offsetUnset with attributes removes them.
     */
    #[Test]
    public function it_offset_unset_with_attributes_removes_them(): void
    {
        $thread = new Thread(['custom' => 'value']);

        $this->assertTrue(isset($thread['custom']));

        unset($thread['custom']);

        $this->assertFalse(isset($thread['custom']));
        $this->assertNull($thread['custom']);
    }

    /**
     * Test magic __get with declared properties.
     */
    #[Test]
    public function it_magic_get_with_declared_properties(): void
    {
        $thread = new Thread(['id' => 321, 'owner' => 88]);

        $this->assertSame(321, $thread->id);
        $this->assertSame(88, $thread->owner);
    }

    /**
     * Test magic __get with attributes.
     */
    #[Test]
    public function it_magic_get_with_attributes(): void
    {
        $thread = new Thread(['custom_property' => 'test_value']);

        $this->assertSame('test_value', $thread->custom_property);
    }

    /**
     * Test magic __get returns null for nonexistent properties.
     */
    #[Test]
    public function it_magic_get_returns_null_for_nonexistent(): void
    {
        $thread = new Thread([]);

        $this->assertNull($thread->nonexistent_property);
    }

    /**
     * Test magic __set with declared properties.
     */
    #[Test]
    public function it_magic_set_with_declared_properties(): void
    {
        $thread = new Thread([]);
        $thread->id = 999;
        $thread->owner = 123;

        $this->assertSame(999, $thread->getId());
        $this->assertSame(123, $thread->getOwner());
    }

    /**
     * Test magic __set with attributes.
     */
    #[Test]
    public function it_magic_set_with_attributes(): void
    {
        $thread = new Thread([]);
        $thread->dynamic_field = 'dynamic_value';

        $this->assertSame('dynamic_value', $thread->getAttribute('dynamic_field'));
    }

    /**
     * Test magic __isset with declared properties.
     */
    #[Test]
    public function it_magic_isset_with_declared_properties(): void
    {
        $thread = new Thread(['id' => 100]);

        $this->assertTrue(isset($thread->id));
        $this->assertFalse(isset($thread->owner));
    }

    /**
     * Test magic __isset with attributes.
     */
    #[Test]
    public function it_magic_isset_with_attributes(): void
    {
        $thread = new Thread(['custom' => 'exists']);

        $this->assertTrue(isset($thread->custom));
        $this->assertFalse(isset($thread->nonexistent));
    }

    /**
     * Test handling of array properties (thread, context, members).
     */
    #[Test]
    public function it_array_properties_handled_correctly(): void
    {
        $threadData = ['message_count' => 10, 'unread' => 3];
        $contextData = ['type' => 'project', 'id' => 999];
        $membersData = [1, 2, 3, 4, 5];

        $thread = new Thread([
            'thread' => $threadData,
            'context' => $contextData,
            'members' => $membersData,
        ]);

        $this->assertSame($threadData, $thread->getThread());
        $this->assertSame($contextData, $thread->getContext());
        $this->assertSame($membersData, $thread->getMembers());
    }

    /**
     * Test handling of empty array properties.
     */
    #[Test]
    public function it_empty_array_properties(): void
    {
        $thread = new Thread([
            'thread' => [],
            'context' => [],
            'members' => [],
        ]);

        $this->assertSame([], $thread->getThread());
        $this->assertSame([], $thread->getContext());
        $this->assertSame([], $thread->getMembers());
    }

    /**
     * Test handling of different thread types.
     */
    #[Test]
    public function it_different_thread_types(): void
    {
        $privateThread = new Thread(['thread_type' => 'private_chat']);
        $groupThread = new Thread(['thread_type' => 'group_chat']);
        $projectThread = new Thread(['thread_type' => 'project_thread']);

        $this->assertSame('private_chat', $privateThread->getThreadType());
        $this->assertSame('group_chat', $groupThread->getThreadType());
        $this->assertSame('project_thread', $projectThread->getThreadType());
    }

    /**
     * Test complex thread with all fields populated.
     */
    #[Test]
    public function it_complex_thread_with_all_fields(): void
    {
        $data = [
            'id' => 12345,
            'thread' => ['message_count' => 42, 'last_message_id' => 999],
            'context' => ['project_id' => 67890, 'type' => 'support'],
            'members' => [111, 222, 333, 444],
            'owner' => 111,
            'thread_type' => 'group_discussion',
            'time_created' => 1609459200,
            'is_archived' => false,
            'priority' => 'high',
            'tags' => ['urgent', 'feedback'],
        ];

        $thread = new Thread($data);

        // Test declared properties
        $this->assertSame(12345, $thread->getId());
        $this->assertSame(['message_count' => 42, 'last_message_id' => 999], $thread->getThread());
        $this->assertSame(['project_id' => 67890, 'type' => 'support'], $thread->getContext());
        $this->assertSame([111, 222, 333, 444], $thread->getMembers());
        $this->assertSame(111, $thread->getOwner());
        $this->assertSame('group_discussion', $thread->getThreadType());
        $this->assertSame(1609459200, $thread->getTimeCreated());

        // Test custom attributes
        $this->assertFalse($thread->getAttribute('is_archived'));
        $this->assertSame('high', $thread->getAttribute('priority'));
        $this->assertSame(['urgent', 'feedback'], $thread->getAttribute('tags'));

        // Test array conversion includes everything
        $array = $thread->toArray();
        $this->assertArrayHasKey('is_archived', $array);
        $this->assertArrayHasKey('priority', $array);
        $this->assertArrayHasKey('tags', $array);
    }

    /**
     * Test handling of null members array.
     */
    #[Test]
    public function it_null_members_array(): void
    {
        $thread = new Thread(['id' => 123]);

        $this->assertNull($thread->getMembers());
    }

    /**
     * Test handling of numeric edge cases.
     */
    #[Test]
    public function it_numeric_edge_cases(): void
    {
        $thread = new Thread([
            'id' => 0,
            'owner' => 0,
            'time_created' => 0,
        ]);

        $this->assertSame(0, $thread->getId());
        $this->assertSame(0, $thread->getOwner());
        $this->assertSame(0, $thread->getTimeCreated());
    }

    /**
     * Test immutability of original data array after instantiation.
     */
    #[Test]
    public function it_original_data_array_not_modified(): void
    {
        $originalData = ['id' => 123, 'owner' => 100];
        $thread = new Thread($originalData);
        
        $thread->fill(['id' => 456]);
        
        // Original array should remain unchanged
        $this->assertSame(123, $originalData['id']);
        $this->assertSame(100, $originalData['owner']);
    }
}