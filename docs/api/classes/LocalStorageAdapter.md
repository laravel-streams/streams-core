[Streams Platform Client Api - v1.0.2](../README.md) / [Exports](../modules.md) / LocalStorageAdapter

# Class: LocalStorageAdapter

## Hierarchy

- [`StorageAdapter`](StorageAdapter.md)

  ↳ **`LocalStorageAdapter`**

## Table of contents

### Constructors

- [constructor](LocalStorageAdapter.md#constructor)

### Properties

- [storage](LocalStorageAdapter.md#storage)
- [defaultMaxListeners](LocalStorageAdapter.md#defaultmaxlisteners)

### Methods

- [addListener](LocalStorageAdapter.md#addlistener)
- [clear](LocalStorageAdapter.md#clear)
- [emit](LocalStorageAdapter.md#emit)
- [emitAsync](LocalStorageAdapter.md#emitasync)
- [eventNames](LocalStorageAdapter.md#eventnames)
- [get](LocalStorageAdapter.md#get)
- [getMaxListeners](LocalStorageAdapter.md#getmaxlisteners)
- [has](LocalStorageAdapter.md#has)
- [hasListeners](LocalStorageAdapter.md#haslisteners)
- [listenTo](LocalStorageAdapter.md#listento)
- [listenerCount](LocalStorageAdapter.md#listenercount)
- [listeners](LocalStorageAdapter.md#listeners)
- [listenersAny](LocalStorageAdapter.md#listenersany)
- [many](LocalStorageAdapter.md#many)
- [off](LocalStorageAdapter.md#off)
- [offAny](LocalStorageAdapter.md#offany)
- [on](LocalStorageAdapter.md#on)
- [onAny](LocalStorageAdapter.md#onany)
- [once](LocalStorageAdapter.md#once)
- [prependAny](LocalStorageAdapter.md#prependany)
- [prependListener](LocalStorageAdapter.md#prependlistener)
- [prependMany](LocalStorageAdapter.md#prependmany)
- [prependOnceListener](LocalStorageAdapter.md#prependoncelistener)
- [removeAllListeners](LocalStorageAdapter.md#removealllisteners)
- [removeListener](LocalStorageAdapter.md#removelistener)
- [set](LocalStorageAdapter.md#set)
- [setMaxListeners](LocalStorageAdapter.md#setmaxlisteners)
- [stopListeningTo](LocalStorageAdapter.md#stoplisteningto)
- [unset](LocalStorageAdapter.md#unset)
- [waitFor](LocalStorageAdapter.md#waitfor)
- [once](LocalStorageAdapter.md#once)

## Constructors

### constructor

• **new LocalStorageAdapter**()

#### Overrides

[StorageAdapter](StorageAdapter.md).[constructor](StorageAdapter.md#constructor)

#### Defined in

[resources/lib/Storage/LocalStorageAdapter.ts:5](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Storage/LocalStorageAdapter.ts#L5)

## Properties

### storage

• `Protected` **storage**: `Storage`

#### Inherited from

[StorageAdapter](StorageAdapter.md).[storage](StorageAdapter.md#storage)

___

### defaultMaxListeners

▪ `Static` **defaultMaxListeners**: `number`

#### Inherited from

[StorageAdapter](StorageAdapter.md).[defaultMaxListeners](StorageAdapter.md#defaultmaxlisteners)

#### Defined in

node_modules/eventemitter2/eventemitter2.d.ts:149

## Methods

### addListener

▸ **addListener**(`event`, `listener`): `Listener` \| [`LocalStorageAdapter`](LocalStorageAdapter.md)

#### Parameters

| Name | Type |
| :------ | :------ |
| `event` | `string` \| `symbol` \| `event`[] |
| `listener` | `ListenerFn` |

#### Returns

`Listener` \| [`LocalStorageAdapter`](LocalStorageAdapter.md)

#### Inherited from

[StorageAdapter](StorageAdapter.md).[addListener](StorageAdapter.md#addlistener)

#### Defined in

node_modules/eventemitter2/eventemitter2.d.ts:121

___

### clear

▸ **clear**(): [`LocalStorageAdapter`](LocalStorageAdapter.md)

#### Returns

[`LocalStorageAdapter`](LocalStorageAdapter.md)

#### Inherited from

[StorageAdapter](StorageAdapter.md).[clear](StorageAdapter.md#clear)

#### Defined in

[resources/lib/Storage/StorageAdapter.ts:42](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Storage/StorageAdapter.ts#L42)

___

### emit

▸ **emit**(`event`, ...`values`): `boolean`

#### Parameters

| Name | Type |
| :------ | :------ |
| `event` | `string` \| `symbol` \| `event`[] |
| `...values` | `any`[] |

#### Returns

`boolean`

#### Inherited from

[StorageAdapter](StorageAdapter.md).[emit](StorageAdapter.md#emit)

#### Defined in

node_modules/eventemitter2/eventemitter2.d.ts:119

___

### emitAsync

▸ **emitAsync**(`event`, ...`values`): `Promise`<`any`[]\>

#### Parameters

| Name | Type |
| :------ | :------ |
| `event` | `string` \| `symbol` \| `event`[] |
| `...values` | `any`[] |

#### Returns

`Promise`<`any`[]\>

#### Inherited from

[StorageAdapter](StorageAdapter.md).[emitAsync](StorageAdapter.md#emitasync)

#### Defined in

node_modules/eventemitter2/eventemitter2.d.ts:120

___

### eventNames

▸ **eventNames**(`nsAsArray?`): (`string` \| `symbol` \| `event`[])[]

#### Parameters

| Name | Type |
| :------ | :------ |
| `nsAsArray?` | `boolean` |

#### Returns

(`string` \| `symbol` \| `event`[])[]

#### Inherited from

[StorageAdapter](StorageAdapter.md).[eventNames](StorageAdapter.md#eventnames)

#### Defined in

node_modules/eventemitter2/eventemitter2.d.ts:136

___

### get

▸ **get**<`T`\>(`key`, `defaultValue?`): `T`

#### Type parameters

| Name |
| :------ |
| `T` |

#### Parameters

| Name | Type |
| :------ | :------ |
| `key` | `string` |
| `defaultValue?` | `T` |

#### Returns

`T`

#### Inherited from

[StorageAdapter](StorageAdapter.md).[get](StorageAdapter.md#get)

#### Defined in

[resources/lib/Storage/StorageAdapter.ts:15](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Storage/StorageAdapter.ts#L15)

___

### getMaxListeners

▸ **getMaxListeners**(): `number`

#### Returns

`number`

#### Inherited from

[StorageAdapter](StorageAdapter.md).[getMaxListeners](StorageAdapter.md#getmaxlisteners)

#### Defined in

node_modules/eventemitter2/eventemitter2.d.ts:135

___

### has

▸ **has**(`key`): `boolean`

#### Parameters

| Name | Type |
| :------ | :------ |
| `key` | `string` |

#### Returns

`boolean`

#### Inherited from

[StorageAdapter](StorageAdapter.md).[has](StorageAdapter.md#has)

#### Defined in

[resources/lib/Storage/StorageAdapter.ts:24](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Storage/StorageAdapter.ts#L24)

___

### hasListeners

▸ **hasListeners**(`event?`): `Boolean`

#### Parameters

| Name | Type |
| :------ | :------ |
| `event?` | `String` |

#### Returns

`Boolean`

#### Inherited from

[StorageAdapter](StorageAdapter.md).[hasListeners](StorageAdapter.md#haslisteners)

#### Defined in

node_modules/eventemitter2/eventemitter2.d.ts:147

___

### listenTo

▸ **listenTo**(`target`, `events`, `options?`): [`LocalStorageAdapter`](LocalStorageAdapter.md)

#### Parameters

| Name | Type |
| :------ | :------ |
| `target` | `GeneralEventEmitter` |
| `events` | `string` \| `symbol` \| `event`[] |
| `options?` | `ListenToOptions` |

#### Returns

[`LocalStorageAdapter`](LocalStorageAdapter.md)

#### Inherited from

[StorageAdapter](StorageAdapter.md).[listenTo](StorageAdapter.md#listento)

#### Defined in

node_modules/eventemitter2/eventemitter2.d.ts:143

▸ **listenTo**(`target`, `events`, `options?`): [`LocalStorageAdapter`](LocalStorageAdapter.md)

#### Parameters

| Name | Type |
| :------ | :------ |
| `target` | `GeneralEventEmitter` |
| `events` | `event`[] |
| `options?` | `ListenToOptions` |

#### Returns

[`LocalStorageAdapter`](LocalStorageAdapter.md)

#### Inherited from

[StorageAdapter](StorageAdapter.md).[listenTo](StorageAdapter.md#listento)

#### Defined in

node_modules/eventemitter2/eventemitter2.d.ts:144

▸ **listenTo**(`target`, `events`, `options?`): [`LocalStorageAdapter`](LocalStorageAdapter.md)

#### Parameters

| Name | Type |
| :------ | :------ |
| `target` | `GeneralEventEmitter` |
| `events` | `Object` |
| `options?` | `ListenToOptions` |

#### Returns

[`LocalStorageAdapter`](LocalStorageAdapter.md)

#### Inherited from

[StorageAdapter](StorageAdapter.md).[listenTo](StorageAdapter.md#listento)

#### Defined in

node_modules/eventemitter2/eventemitter2.d.ts:145

___

### listenerCount

▸ **listenerCount**(`event?`): `number`

#### Parameters

| Name | Type |
| :------ | :------ |
| `event?` | `string` \| `symbol` \| `event`[] |

#### Returns

`number`

#### Inherited from

[StorageAdapter](StorageAdapter.md).[listenerCount](StorageAdapter.md#listenercount)

#### Defined in

node_modules/eventemitter2/eventemitter2.d.ts:137

___

### listeners

▸ **listeners**(`event?`): `ListenerFn`[]

#### Parameters

| Name | Type |
| :------ | :------ |
| `event?` | `string` \| `symbol` \| `event`[] |

#### Returns

`ListenerFn`[]

#### Inherited from

[StorageAdapter](StorageAdapter.md).[listeners](StorageAdapter.md#listeners)

#### Defined in

node_modules/eventemitter2/eventemitter2.d.ts:138

___

### listenersAny

▸ **listenersAny**(): `ListenerFn`[]

#### Returns

`ListenerFn`[]

#### Inherited from

[StorageAdapter](StorageAdapter.md).[listenersAny](StorageAdapter.md#listenersany)

#### Defined in

node_modules/eventemitter2/eventemitter2.d.ts:139

___

### many

▸ **many**(`event`, `timesToListen`, `listener`, `options?`): `Listener` \| [`LocalStorageAdapter`](LocalStorageAdapter.md)

#### Parameters

| Name | Type |
| :------ | :------ |
| `event` | `string` \| `symbol` \| `event`[] |
| `timesToListen` | `number` |
| `listener` | `ListenerFn` |
| `options?` | `boolean` \| `OnOptions` |

#### Returns

`Listener` \| [`LocalStorageAdapter`](LocalStorageAdapter.md)

#### Inherited from

[StorageAdapter](StorageAdapter.md).[many](StorageAdapter.md#many)

#### Defined in

node_modules/eventemitter2/eventemitter2.d.ts:126

___

### off

▸ **off**(`event`, `listener`): [`LocalStorageAdapter`](LocalStorageAdapter.md)

#### Parameters

| Name | Type |
| :------ | :------ |
| `event` | `string` \| `symbol` \| `event`[] |
| `listener` | `ListenerFn` |

#### Returns

[`LocalStorageAdapter`](LocalStorageAdapter.md)

#### Inherited from

[StorageAdapter](StorageAdapter.md).[off](StorageAdapter.md#off)

#### Defined in

node_modules/eventemitter2/eventemitter2.d.ts:132

___

### offAny

▸ **offAny**(`listener`): [`LocalStorageAdapter`](LocalStorageAdapter.md)

#### Parameters

| Name | Type |
| :------ | :------ |
| `listener` | `ListenerFn` |

#### Returns

[`LocalStorageAdapter`](LocalStorageAdapter.md)

#### Inherited from

[StorageAdapter](StorageAdapter.md).[offAny](StorageAdapter.md#offany)

#### Defined in

node_modules/eventemitter2/eventemitter2.d.ts:130

___

### on

▸ **on**(`event`, `listener`, `options?`): `Listener` \| [`LocalStorageAdapter`](LocalStorageAdapter.md)

#### Parameters

| Name | Type |
| :------ | :------ |
| `event` | `string` \| `symbol` \| `event`[] |
| `listener` | `ListenerFn` |
| `options?` | `boolean` \| `OnOptions` |

#### Returns

`Listener` \| [`LocalStorageAdapter`](LocalStorageAdapter.md)

#### Inherited from

[StorageAdapter](StorageAdapter.md).[on](StorageAdapter.md#on)

#### Defined in

node_modules/eventemitter2/eventemitter2.d.ts:122

___

### onAny

▸ **onAny**(`listener`): [`LocalStorageAdapter`](LocalStorageAdapter.md)

#### Parameters

| Name | Type |
| :------ | :------ |
| `listener` | `EventAndListener` |

#### Returns

[`LocalStorageAdapter`](LocalStorageAdapter.md)

#### Inherited from

[StorageAdapter](StorageAdapter.md).[onAny](StorageAdapter.md#onany)

#### Defined in

node_modules/eventemitter2/eventemitter2.d.ts:128

___

### once

▸ **once**(`event`, `listener`, `options?`): `Listener` \| [`LocalStorageAdapter`](LocalStorageAdapter.md)

#### Parameters

| Name | Type |
| :------ | :------ |
| `event` | `string` \| `symbol` \| `event`[] |
| `listener` | `ListenerFn` |
| `options?` | ``true`` \| `OnOptions` |

#### Returns

`Listener` \| [`LocalStorageAdapter`](LocalStorageAdapter.md)

#### Inherited from

[StorageAdapter](StorageAdapter.md).[once](StorageAdapter.md#once)

#### Defined in

node_modules/eventemitter2/eventemitter2.d.ts:124

___

### prependAny

▸ **prependAny**(`listener`): [`LocalStorageAdapter`](LocalStorageAdapter.md)

#### Parameters

| Name | Type |
| :------ | :------ |
| `listener` | `EventAndListener` |

#### Returns

[`LocalStorageAdapter`](LocalStorageAdapter.md)

#### Inherited from

[StorageAdapter](StorageAdapter.md).[prependAny](StorageAdapter.md#prependany)

#### Defined in

node_modules/eventemitter2/eventemitter2.d.ts:129

___

### prependListener

▸ **prependListener**(`event`, `listener`, `options?`): `Listener` \| [`LocalStorageAdapter`](LocalStorageAdapter.md)

#### Parameters

| Name | Type |
| :------ | :------ |
| `event` | `string` \| `symbol` \| `event`[] |
| `listener` | `ListenerFn` |
| `options?` | `boolean` \| `OnOptions` |

#### Returns

`Listener` \| [`LocalStorageAdapter`](LocalStorageAdapter.md)

#### Inherited from

[StorageAdapter](StorageAdapter.md).[prependListener](StorageAdapter.md#prependlistener)

#### Defined in

node_modules/eventemitter2/eventemitter2.d.ts:123

___

### prependMany

▸ **prependMany**(`event`, `timesToListen`, `listener`, `options?`): `Listener` \| [`LocalStorageAdapter`](LocalStorageAdapter.md)

#### Parameters

| Name | Type |
| :------ | :------ |
| `event` | `string` \| `symbol` \| `event`[] |
| `timesToListen` | `number` |
| `listener` | `ListenerFn` |
| `options?` | `boolean` \| `OnOptions` |

#### Returns

`Listener` \| [`LocalStorageAdapter`](LocalStorageAdapter.md)

#### Inherited from

[StorageAdapter](StorageAdapter.md).[prependMany](StorageAdapter.md#prependmany)

#### Defined in

node_modules/eventemitter2/eventemitter2.d.ts:127

___

### prependOnceListener

▸ **prependOnceListener**(`event`, `listener`, `options?`): `Listener` \| [`LocalStorageAdapter`](LocalStorageAdapter.md)

#### Parameters

| Name | Type |
| :------ | :------ |
| `event` | `string` \| `symbol` \| `event`[] |
| `listener` | `ListenerFn` |
| `options?` | `boolean` \| `OnOptions` |

#### Returns

`Listener` \| [`LocalStorageAdapter`](LocalStorageAdapter.md)

#### Inherited from

[StorageAdapter](StorageAdapter.md).[prependOnceListener](StorageAdapter.md#prependoncelistener)

#### Defined in

node_modules/eventemitter2/eventemitter2.d.ts:125

___

### removeAllListeners

▸ **removeAllListeners**(`event?`): [`LocalStorageAdapter`](LocalStorageAdapter.md)

#### Parameters

| Name | Type |
| :------ | :------ |
| `event?` | `string` \| `symbol` \| `event`[] |

#### Returns

[`LocalStorageAdapter`](LocalStorageAdapter.md)

#### Inherited from

[StorageAdapter](StorageAdapter.md).[removeAllListeners](StorageAdapter.md#removealllisteners)

#### Defined in

node_modules/eventemitter2/eventemitter2.d.ts:133

___

### removeListener

▸ **removeListener**(`event`, `listener`): [`LocalStorageAdapter`](LocalStorageAdapter.md)

#### Parameters

| Name | Type |
| :------ | :------ |
| `event` | `string` \| `symbol` \| `event`[] |
| `listener` | `ListenerFn` |

#### Returns

[`LocalStorageAdapter`](LocalStorageAdapter.md)

#### Inherited from

[StorageAdapter](StorageAdapter.md).[removeListener](StorageAdapter.md#removelistener)

#### Defined in

node_modules/eventemitter2/eventemitter2.d.ts:131

___

### set

▸ **set**(`key`, `value`): [`LocalStorageAdapter`](LocalStorageAdapter.md)

#### Parameters

| Name | Type |
| :------ | :------ |
| `key` | `string` |
| `value` | `any` |

#### Returns

[`LocalStorageAdapter`](LocalStorageAdapter.md)

#### Inherited from

[StorageAdapter](StorageAdapter.md).[set](StorageAdapter.md#set)

#### Defined in

[resources/lib/Storage/StorageAdapter.ts:28](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Storage/StorageAdapter.ts#L28)

___

### setMaxListeners

▸ **setMaxListeners**(`n`): `void`

#### Parameters

| Name | Type |
| :------ | :------ |
| `n` | `number` |

#### Returns

`void`

#### Inherited from

[StorageAdapter](StorageAdapter.md).[setMaxListeners](StorageAdapter.md#setmaxlisteners)

#### Defined in

node_modules/eventemitter2/eventemitter2.d.ts:134

___

### stopListeningTo

▸ **stopListeningTo**(`target?`, `event?`): `Boolean`

#### Parameters

| Name | Type |
| :------ | :------ |
| `target?` | `GeneralEventEmitter` |
| `event?` | `string` \| `symbol` \| `event`[] |

#### Returns

`Boolean`

#### Inherited from

[StorageAdapter](StorageAdapter.md).[stopListeningTo](StorageAdapter.md#stoplisteningto)

#### Defined in

node_modules/eventemitter2/eventemitter2.d.ts:146

___

### unset

▸ **unset**(`key`): [`LocalStorageAdapter`](LocalStorageAdapter.md)

#### Parameters

| Name | Type |
| :------ | :------ |
| `key` | `string` |

#### Returns

[`LocalStorageAdapter`](LocalStorageAdapter.md)

#### Inherited from

[StorageAdapter](StorageAdapter.md).[unset](StorageAdapter.md#unset)

#### Defined in

[resources/lib/Storage/StorageAdapter.ts:36](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Storage/StorageAdapter.ts#L36)

___

### waitFor

▸ **waitFor**(`event`, `timeout?`): `CancelablePromise`<`any`[]\>

#### Parameters

| Name | Type |
| :------ | :------ |
| `event` | `string` \| `symbol` \| `event`[] |
| `timeout?` | `number` |

#### Returns

`CancelablePromise`<`any`[]\>

#### Inherited from

[StorageAdapter](StorageAdapter.md).[waitFor](StorageAdapter.md#waitfor)

#### Defined in

node_modules/eventemitter2/eventemitter2.d.ts:140

▸ **waitFor**(`event`, `filter?`): `CancelablePromise`<`any`[]\>

#### Parameters

| Name | Type |
| :------ | :------ |
| `event` | `string` \| `symbol` \| `event`[] |
| `filter?` | `WaitForFilter` |

#### Returns

`CancelablePromise`<`any`[]\>

#### Inherited from

[StorageAdapter](StorageAdapter.md).[waitFor](StorageAdapter.md#waitfor)

#### Defined in

node_modules/eventemitter2/eventemitter2.d.ts:141

▸ **waitFor**(`event`, `options?`): `CancelablePromise`<`any`[]\>

#### Parameters

| Name | Type |
| :------ | :------ |
| `event` | `string` \| `symbol` \| `event`[] |
| `options?` | `WaitForOptions` |

#### Returns

`CancelablePromise`<`any`[]\>

#### Inherited from

[StorageAdapter](StorageAdapter.md).[waitFor](StorageAdapter.md#waitfor)

#### Defined in

node_modules/eventemitter2/eventemitter2.d.ts:142

___

### once

▸ `Static` **once**(`emitter`, `event`, `options?`): `CancelablePromise`<`any`[]\>

#### Parameters

| Name | Type |
| :------ | :------ |
| `emitter` | `EventEmitter2` |
| `event` | `string` \| `symbol` \| `event`[] |
| `options?` | `OnceOptions` |

#### Returns

`CancelablePromise`<`any`[]\>

#### Inherited from

[StorageAdapter](StorageAdapter.md).[once](StorageAdapter.md#once)

#### Defined in

node_modules/eventemitter2/eventemitter2.d.ts:148
