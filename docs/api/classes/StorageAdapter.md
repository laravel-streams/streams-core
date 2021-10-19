[Streams Platform Client Api - v1.0.2](../README.md) / [Exports](../modules.md) / StorageAdapter

# Class: StorageAdapter

## Hierarchy

- `EventEmitter2`

  ↳ **`StorageAdapter`**

  ↳↳ [`LocalStorageAdapter`](LocalStorageAdapter.md)

  ↳↳ [`SessionStorageAdapter`](SessionStorageAdapter.md)

## Implements

- [`StorageAdapterInterface`](../interfaces/StorageAdapterInterface.md)

## Table of contents

### Constructors

- [constructor](StorageAdapter.md#constructor)

### Properties

- [storage](StorageAdapter.md#storage)
- [defaultMaxListeners](StorageAdapter.md#defaultmaxlisteners)

### Methods

- [addListener](StorageAdapter.md#addlistener)
- [clear](StorageAdapter.md#clear)
- [emit](StorageAdapter.md#emit)
- [emitAsync](StorageAdapter.md#emitasync)
- [eventNames](StorageAdapter.md#eventnames)
- [get](StorageAdapter.md#get)
- [getMaxListeners](StorageAdapter.md#getmaxlisteners)
- [has](StorageAdapter.md#has)
- [hasListeners](StorageAdapter.md#haslisteners)
- [listenTo](StorageAdapter.md#listento)
- [listenerCount](StorageAdapter.md#listenercount)
- [listeners](StorageAdapter.md#listeners)
- [listenersAny](StorageAdapter.md#listenersany)
- [many](StorageAdapter.md#many)
- [off](StorageAdapter.md#off)
- [offAny](StorageAdapter.md#offany)
- [on](StorageAdapter.md#on)
- [onAny](StorageAdapter.md#onany)
- [once](StorageAdapter.md#once)
- [prependAny](StorageAdapter.md#prependany)
- [prependListener](StorageAdapter.md#prependlistener)
- [prependMany](StorageAdapter.md#prependmany)
- [prependOnceListener](StorageAdapter.md#prependoncelistener)
- [removeAllListeners](StorageAdapter.md#removealllisteners)
- [removeListener](StorageAdapter.md#removelistener)
- [set](StorageAdapter.md#set)
- [setMaxListeners](StorageAdapter.md#setmaxlisteners)
- [stopListeningTo](StorageAdapter.md#stoplisteningto)
- [unset](StorageAdapter.md#unset)
- [waitFor](StorageAdapter.md#waitfor)
- [once](StorageAdapter.md#once)

## Constructors

### constructor

• **new StorageAdapter**(`storage`)

#### Parameters

| Name | Type |
| :------ | :------ |
| `storage` | `Storage` |

#### Overrides

EventEmitter2.constructor

#### Defined in

[resources/lib/Storage/StorageAdapter.ts:8](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Storage/StorageAdapter.ts#L8)

## Properties

### storage

• `Protected` **storage**: `Storage`

___

### defaultMaxListeners

▪ `Static` **defaultMaxListeners**: `number`

#### Inherited from

EventEmitter2.defaultMaxListeners

#### Defined in

node_modules/eventemitter2/eventemitter2.d.ts:149

## Methods

### addListener

▸ **addListener**(`event`, `listener`): `Listener` \| [`StorageAdapter`](StorageAdapter.md)

#### Parameters

| Name | Type |
| :------ | :------ |
| `event` | `string` \| `symbol` \| `event`[] |
| `listener` | `ListenerFn` |

#### Returns

`Listener` \| [`StorageAdapter`](StorageAdapter.md)

#### Inherited from

EventEmitter2.addListener

#### Defined in

node_modules/eventemitter2/eventemitter2.d.ts:121

___

### clear

▸ **clear**(): [`StorageAdapter`](StorageAdapter.md)

#### Returns

[`StorageAdapter`](StorageAdapter.md)

#### Implementation of

[StorageAdapterInterface](../interfaces/StorageAdapterInterface.md).[clear](../interfaces/StorageAdapterInterface.md#clear)

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

EventEmitter2.emit

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

EventEmitter2.emitAsync

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

EventEmitter2.eventNames

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

#### Implementation of

[StorageAdapterInterface](../interfaces/StorageAdapterInterface.md).[get](../interfaces/StorageAdapterInterface.md#get)

#### Defined in

[resources/lib/Storage/StorageAdapter.ts:15](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Storage/StorageAdapter.ts#L15)

___

### getMaxListeners

▸ **getMaxListeners**(): `number`

#### Returns

`number`

#### Inherited from

EventEmitter2.getMaxListeners

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

#### Implementation of

[StorageAdapterInterface](../interfaces/StorageAdapterInterface.md).[has](../interfaces/StorageAdapterInterface.md#has)

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

EventEmitter2.hasListeners

#### Defined in

node_modules/eventemitter2/eventemitter2.d.ts:147

___

### listenTo

▸ **listenTo**(`target`, `events`, `options?`): [`StorageAdapter`](StorageAdapter.md)

#### Parameters

| Name | Type |
| :------ | :------ |
| `target` | `GeneralEventEmitter` |
| `events` | `string` \| `symbol` \| `event`[] |
| `options?` | `ListenToOptions` |

#### Returns

[`StorageAdapter`](StorageAdapter.md)

#### Inherited from

EventEmitter2.listenTo

#### Defined in

node_modules/eventemitter2/eventemitter2.d.ts:143

▸ **listenTo**(`target`, `events`, `options?`): [`StorageAdapter`](StorageAdapter.md)

#### Parameters

| Name | Type |
| :------ | :------ |
| `target` | `GeneralEventEmitter` |
| `events` | `event`[] |
| `options?` | `ListenToOptions` |

#### Returns

[`StorageAdapter`](StorageAdapter.md)

#### Inherited from

EventEmitter2.listenTo

#### Defined in

node_modules/eventemitter2/eventemitter2.d.ts:144

▸ **listenTo**(`target`, `events`, `options?`): [`StorageAdapter`](StorageAdapter.md)

#### Parameters

| Name | Type |
| :------ | :------ |
| `target` | `GeneralEventEmitter` |
| `events` | `Object` |
| `options?` | `ListenToOptions` |

#### Returns

[`StorageAdapter`](StorageAdapter.md)

#### Inherited from

EventEmitter2.listenTo

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

EventEmitter2.listenerCount

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

EventEmitter2.listeners

#### Defined in

node_modules/eventemitter2/eventemitter2.d.ts:138

___

### listenersAny

▸ **listenersAny**(): `ListenerFn`[]

#### Returns

`ListenerFn`[]

#### Inherited from

EventEmitter2.listenersAny

#### Defined in

node_modules/eventemitter2/eventemitter2.d.ts:139

___

### many

▸ **many**(`event`, `timesToListen`, `listener`, `options?`): `Listener` \| [`StorageAdapter`](StorageAdapter.md)

#### Parameters

| Name | Type |
| :------ | :------ |
| `event` | `string` \| `symbol` \| `event`[] |
| `timesToListen` | `number` |
| `listener` | `ListenerFn` |
| `options?` | `boolean` \| `OnOptions` |

#### Returns

`Listener` \| [`StorageAdapter`](StorageAdapter.md)

#### Inherited from

EventEmitter2.many

#### Defined in

node_modules/eventemitter2/eventemitter2.d.ts:126

___

### off

▸ **off**(`event`, `listener`): [`StorageAdapter`](StorageAdapter.md)

#### Parameters

| Name | Type |
| :------ | :------ |
| `event` | `string` \| `symbol` \| `event`[] |
| `listener` | `ListenerFn` |

#### Returns

[`StorageAdapter`](StorageAdapter.md)

#### Inherited from

EventEmitter2.off

#### Defined in

node_modules/eventemitter2/eventemitter2.d.ts:132

___

### offAny

▸ **offAny**(`listener`): [`StorageAdapter`](StorageAdapter.md)

#### Parameters

| Name | Type |
| :------ | :------ |
| `listener` | `ListenerFn` |

#### Returns

[`StorageAdapter`](StorageAdapter.md)

#### Inherited from

EventEmitter2.offAny

#### Defined in

node_modules/eventemitter2/eventemitter2.d.ts:130

___

### on

▸ **on**(`event`, `listener`, `options?`): `Listener` \| [`StorageAdapter`](StorageAdapter.md)

#### Parameters

| Name | Type |
| :------ | :------ |
| `event` | `string` \| `symbol` \| `event`[] |
| `listener` | `ListenerFn` |
| `options?` | `boolean` \| `OnOptions` |

#### Returns

`Listener` \| [`StorageAdapter`](StorageAdapter.md)

#### Inherited from

EventEmitter2.on

#### Defined in

node_modules/eventemitter2/eventemitter2.d.ts:122

___

### onAny

▸ **onAny**(`listener`): [`StorageAdapter`](StorageAdapter.md)

#### Parameters

| Name | Type |
| :------ | :------ |
| `listener` | `EventAndListener` |

#### Returns

[`StorageAdapter`](StorageAdapter.md)

#### Inherited from

EventEmitter2.onAny

#### Defined in

node_modules/eventemitter2/eventemitter2.d.ts:128

___

### once

▸ **once**(`event`, `listener`, `options?`): `Listener` \| [`StorageAdapter`](StorageAdapter.md)

#### Parameters

| Name | Type |
| :------ | :------ |
| `event` | `string` \| `symbol` \| `event`[] |
| `listener` | `ListenerFn` |
| `options?` | ``true`` \| `OnOptions` |

#### Returns

`Listener` \| [`StorageAdapter`](StorageAdapter.md)

#### Inherited from

EventEmitter2.once

#### Defined in

node_modules/eventemitter2/eventemitter2.d.ts:124

___

### prependAny

▸ **prependAny**(`listener`): [`StorageAdapter`](StorageAdapter.md)

#### Parameters

| Name | Type |
| :------ | :------ |
| `listener` | `EventAndListener` |

#### Returns

[`StorageAdapter`](StorageAdapter.md)

#### Inherited from

EventEmitter2.prependAny

#### Defined in

node_modules/eventemitter2/eventemitter2.d.ts:129

___

### prependListener

▸ **prependListener**(`event`, `listener`, `options?`): `Listener` \| [`StorageAdapter`](StorageAdapter.md)

#### Parameters

| Name | Type |
| :------ | :------ |
| `event` | `string` \| `symbol` \| `event`[] |
| `listener` | `ListenerFn` |
| `options?` | `boolean` \| `OnOptions` |

#### Returns

`Listener` \| [`StorageAdapter`](StorageAdapter.md)

#### Inherited from

EventEmitter2.prependListener

#### Defined in

node_modules/eventemitter2/eventemitter2.d.ts:123

___

### prependMany

▸ **prependMany**(`event`, `timesToListen`, `listener`, `options?`): `Listener` \| [`StorageAdapter`](StorageAdapter.md)

#### Parameters

| Name | Type |
| :------ | :------ |
| `event` | `string` \| `symbol` \| `event`[] |
| `timesToListen` | `number` |
| `listener` | `ListenerFn` |
| `options?` | `boolean` \| `OnOptions` |

#### Returns

`Listener` \| [`StorageAdapter`](StorageAdapter.md)

#### Inherited from

EventEmitter2.prependMany

#### Defined in

node_modules/eventemitter2/eventemitter2.d.ts:127

___

### prependOnceListener

▸ **prependOnceListener**(`event`, `listener`, `options?`): `Listener` \| [`StorageAdapter`](StorageAdapter.md)

#### Parameters

| Name | Type |
| :------ | :------ |
| `event` | `string` \| `symbol` \| `event`[] |
| `listener` | `ListenerFn` |
| `options?` | `boolean` \| `OnOptions` |

#### Returns

`Listener` \| [`StorageAdapter`](StorageAdapter.md)

#### Inherited from

EventEmitter2.prependOnceListener

#### Defined in

node_modules/eventemitter2/eventemitter2.d.ts:125

___

### removeAllListeners

▸ **removeAllListeners**(`event?`): [`StorageAdapter`](StorageAdapter.md)

#### Parameters

| Name | Type |
| :------ | :------ |
| `event?` | `string` \| `symbol` \| `event`[] |

#### Returns

[`StorageAdapter`](StorageAdapter.md)

#### Inherited from

EventEmitter2.removeAllListeners

#### Defined in

node_modules/eventemitter2/eventemitter2.d.ts:133

___

### removeListener

▸ **removeListener**(`event`, `listener`): [`StorageAdapter`](StorageAdapter.md)

#### Parameters

| Name | Type |
| :------ | :------ |
| `event` | `string` \| `symbol` \| `event`[] |
| `listener` | `ListenerFn` |

#### Returns

[`StorageAdapter`](StorageAdapter.md)

#### Inherited from

EventEmitter2.removeListener

#### Defined in

node_modules/eventemitter2/eventemitter2.d.ts:131

___

### set

▸ **set**(`key`, `value`): [`StorageAdapter`](StorageAdapter.md)

#### Parameters

| Name | Type |
| :------ | :------ |
| `key` | `string` |
| `value` | `any` |

#### Returns

[`StorageAdapter`](StorageAdapter.md)

#### Implementation of

[StorageAdapterInterface](../interfaces/StorageAdapterInterface.md).[set](../interfaces/StorageAdapterInterface.md#set)

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

EventEmitter2.setMaxListeners

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

EventEmitter2.stopListeningTo

#### Defined in

node_modules/eventemitter2/eventemitter2.d.ts:146

___

### unset

▸ **unset**(`key`): [`StorageAdapter`](StorageAdapter.md)

#### Parameters

| Name | Type |
| :------ | :------ |
| `key` | `string` |

#### Returns

[`StorageAdapter`](StorageAdapter.md)

#### Implementation of

[StorageAdapterInterface](../interfaces/StorageAdapterInterface.md).[unset](../interfaces/StorageAdapterInterface.md#unset)

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

EventEmitter2.waitFor

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

EventEmitter2.waitFor

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

EventEmitter2.waitFor

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

EventEmitter2.once

#### Defined in

node_modules/eventemitter2/eventemitter2.d.ts:148
