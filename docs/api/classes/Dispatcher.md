[Streams Platform Client Api - v1.0.2](../README.md) / [Exports](../modules.md) / Dispatcher

# Class: Dispatcher

## Hierarchy

- `EventEmitter2`

  ↳ **`Dispatcher`**

## Table of contents

### Constructors

- [constructor](Dispatcher.md#constructor)

### Properties

- [anyListeners](Dispatcher.md#anylisteners)
- [defaultMaxListeners](Dispatcher.md#defaultmaxlisteners)

### Methods

- [addListener](Dispatcher.md#addlistener)
- [any](Dispatcher.md#any)
- [emit](Dispatcher.md#emit)
- [emitAsync](Dispatcher.md#emitasync)
- [eventNames](Dispatcher.md#eventnames)
- [getMaxListeners](Dispatcher.md#getmaxlisteners)
- [hasListeners](Dispatcher.md#haslisteners)
- [listenTo](Dispatcher.md#listento)
- [listenerCount](Dispatcher.md#listenercount)
- [listeners](Dispatcher.md#listeners)
- [listenersAny](Dispatcher.md#listenersany)
- [many](Dispatcher.md#many)
- [off](Dispatcher.md#off)
- [offAny](Dispatcher.md#offany)
- [on](Dispatcher.md#on)
- [onAny](Dispatcher.md#onany)
- [once](Dispatcher.md#once)
- [prependAny](Dispatcher.md#prependany)
- [prependListener](Dispatcher.md#prependlistener)
- [prependMany](Dispatcher.md#prependmany)
- [prependOnceListener](Dispatcher.md#prependoncelistener)
- [removeAllListeners](Dispatcher.md#removealllisteners)
- [removeListener](Dispatcher.md#removelistener)
- [setMaxListeners](Dispatcher.md#setmaxlisteners)
- [stopListeningTo](Dispatcher.md#stoplisteningto)
- [waitFor](Dispatcher.md#waitfor)
- [once](Dispatcher.md#once)

## Constructors

### constructor

• **new Dispatcher**(`opts?`)

Create a new Dispatcher instance.

#### Parameters

| Name | Type |
| :------ | :------ |
| `opts?` | `any` |

#### Overrides

EventEmitter2.constructor

#### Defined in

[resources/lib/Dispatcher/Dispatcher.ts:16](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Dispatcher/Dispatcher.ts#L16)

## Properties

### anyListeners

• `Protected` **anyListeners**: (...`args`: `any`[]) => `void`[] = `[]`

#### Defined in

[resources/lib/Dispatcher/Dispatcher.ts:9](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Dispatcher/Dispatcher.ts#L9)

___

### defaultMaxListeners

▪ `Static` **defaultMaxListeners**: `number`

#### Inherited from

EventEmitter2.defaultMaxListeners

#### Defined in

node_modules/eventemitter2/eventemitter2.d.ts:149

## Methods

### addListener

▸ **addListener**<`T`\>(`event`, `listener`): [`Dispatcher`](Dispatcher.md) \| `Listener`

#### Type parameters

| Name | Type |
| :------ | :------ |
| `T` | extends keyof [`DispatcherEvents`](../interfaces/DispatcherEvents.md) |

#### Parameters

| Name | Type |
| :------ | :------ |
| `event` | `T` |
| `listener` | [`ListenerFn`](../interfaces/ListenerFn.md)<`T`\> |

#### Returns

[`Dispatcher`](Dispatcher.md) \| `Listener`

#### Inherited from

EventEmitter2.addListener

#### Defined in

[resources/lib/Dispatcher/Dispatcher.ts:69](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Dispatcher/Dispatcher.ts#L69)

___

### any

▸ **any**(`listener`): `void`

Register an event listener.

#### Parameters

| Name | Type |
| :------ | :------ |
| `listener` | (...`args`: `any`[]) => `void` |

#### Returns

`void`

#### Defined in

[resources/lib/Dispatcher/Dispatcher.ts:41](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Dispatcher/Dispatcher.ts#L41)

___

### emit

▸ **emit**(`eventName`, ...`args`): `boolean`

Emit an event by name.

#### Parameters

| Name | Type |
| :------ | :------ |
| `eventName` | `string` \| `symbol` |
| `...args` | `any`[] |

#### Returns

`boolean`

#### Inherited from

EventEmitter2.emit

#### Defined in

[resources/lib/Dispatcher/Dispatcher.ts:30](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Dispatcher/Dispatcher.ts#L30)

▸ **emit**<`T`\>(`event`, ...`values`): `boolean`

#### Type parameters

| Name | Type |
| :------ | :------ |
| `T` | extends keyof [`DispatcherEvents`](../interfaces/DispatcherEvents.md) |

#### Parameters

| Name | Type |
| :------ | :------ |
| `event` | `T` |
| `...values` | `any`[] |

#### Returns

`boolean`

#### Inherited from

EventEmitter2.emit

#### Defined in

[resources/lib/Dispatcher/Dispatcher.ts:65](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Dispatcher/Dispatcher.ts#L65)

___

### emitAsync

▸ **emitAsync**<`T`\>(`event`, ...`values`): `Promise`<`any`[]\>

#### Type parameters

| Name | Type |
| :------ | :------ |
| `T` | extends keyof [`DispatcherEvents`](../interfaces/DispatcherEvents.md) |

#### Parameters

| Name | Type |
| :------ | :------ |
| `event` | `T` |
| `...values` | `any`[] |

#### Returns

`Promise`<`any`[]\>

#### Inherited from

EventEmitter2.emitAsync

#### Defined in

[resources/lib/Dispatcher/Dispatcher.ts:67](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Dispatcher/Dispatcher.ts#L67)

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

### getMaxListeners

▸ **getMaxListeners**(): `number`

#### Returns

`number`

#### Inherited from

EventEmitter2.getMaxListeners

#### Defined in

node_modules/eventemitter2/eventemitter2.d.ts:135

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

▸ **listenTo**(`target`, `events`, `options?`): [`Dispatcher`](Dispatcher.md)

#### Parameters

| Name | Type |
| :------ | :------ |
| `target` | `GeneralEventEmitter` |
| `events` | `string` \| `symbol` \| `event`[] |
| `options?` | `ListenToOptions` |

#### Returns

[`Dispatcher`](Dispatcher.md)

#### Inherited from

EventEmitter2.listenTo

#### Defined in

node_modules/eventemitter2/eventemitter2.d.ts:143

▸ **listenTo**(`target`, `events`, `options?`): [`Dispatcher`](Dispatcher.md)

#### Parameters

| Name | Type |
| :------ | :------ |
| `target` | `GeneralEventEmitter` |
| `events` | `event`[] |
| `options?` | `ListenToOptions` |

#### Returns

[`Dispatcher`](Dispatcher.md)

#### Inherited from

EventEmitter2.listenTo

#### Defined in

node_modules/eventemitter2/eventemitter2.d.ts:144

▸ **listenTo**(`target`, `events`, `options?`): [`Dispatcher`](Dispatcher.md)

#### Parameters

| Name | Type |
| :------ | :------ |
| `target` | `GeneralEventEmitter` |
| `events` | `Object` |
| `options?` | `ListenToOptions` |

#### Returns

[`Dispatcher`](Dispatcher.md)

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
| `event?` | keyof [`DispatcherEvents`](../interfaces/DispatcherEvents.md) |

#### Returns

`number`

#### Inherited from

EventEmitter2.listenerCount

#### Defined in

[resources/lib/Dispatcher/Dispatcher.ts:89](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Dispatcher/Dispatcher.ts#L89)

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

▸ **many**<`T`\>(`event`, `timesToListen`, `listener`, `options?`): [`Dispatcher`](Dispatcher.md) \| `Listener`

#### Type parameters

| Name | Type |
| :------ | :------ |
| `T` | extends keyof [`DispatcherEvents`](../interfaces/DispatcherEvents.md) |

#### Parameters

| Name | Type |
| :------ | :------ |
| `event` | `T` |
| `timesToListen` | `number` |
| `listener` | [`ListenerFn`](../interfaces/ListenerFn.md)<`T`\> |
| `options?` | `boolean` \| `OnOptions` |

#### Returns

[`Dispatcher`](Dispatcher.md) \| `Listener`

#### Inherited from

EventEmitter2.many

#### Defined in

[resources/lib/Dispatcher/Dispatcher.ts:79](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Dispatcher/Dispatcher.ts#L79)

___

### off

▸ **off**<`T`\>(`event`, `listener`): [`Dispatcher`](Dispatcher.md)

#### Type parameters

| Name | Type |
| :------ | :------ |
| `T` | extends keyof [`DispatcherEvents`](../interfaces/DispatcherEvents.md) |

#### Parameters

| Name | Type |
| :------ | :------ |
| `event` | `T` |
| `listener` | [`ListenerFn`](../interfaces/ListenerFn.md)<`T`\> |

#### Returns

[`Dispatcher`](Dispatcher.md)

#### Inherited from

EventEmitter2.off

#### Defined in

[resources/lib/Dispatcher/Dispatcher.ts:85](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Dispatcher/Dispatcher.ts#L85)

___

### offAny

▸ **offAny**(`listener`): [`Dispatcher`](Dispatcher.md)

#### Parameters

| Name | Type |
| :------ | :------ |
| `listener` | `ListenerFn` |

#### Returns

[`Dispatcher`](Dispatcher.md)

#### Inherited from

EventEmitter2.offAny

#### Defined in

node_modules/eventemitter2/eventemitter2.d.ts:130

___

### on

▸ **on**<`T`\>(`event`, `listener`, `options?`): [`Dispatcher`](Dispatcher.md) \| `Listener`

#### Type parameters

| Name | Type |
| :------ | :------ |
| `T` | extends keyof [`DispatcherEvents`](../interfaces/DispatcherEvents.md) |

#### Parameters

| Name | Type |
| :------ | :------ |
| `event` | `T` |
| `listener` | [`ListenerFn`](../interfaces/ListenerFn.md)<`T`\> |
| `options?` | `boolean` \| `OnOptions` |

#### Returns

[`Dispatcher`](Dispatcher.md) \| `Listener`

#### Inherited from

EventEmitter2.on

#### Defined in

[resources/lib/Dispatcher/Dispatcher.ts:71](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Dispatcher/Dispatcher.ts#L71)

___

### onAny

▸ **onAny**(`listener`): [`Dispatcher`](Dispatcher.md)

#### Parameters

| Name | Type |
| :------ | :------ |
| `listener` | `EventAndListener` |

#### Returns

[`Dispatcher`](Dispatcher.md)

#### Inherited from

EventEmitter2.onAny

#### Defined in

node_modules/eventemitter2/eventemitter2.d.ts:128

___

### once

▸ **once**<`T`\>(`event`, `listener`, `options?`): [`Dispatcher`](Dispatcher.md) \| `Listener`

#### Type parameters

| Name | Type |
| :------ | :------ |
| `T` | extends keyof [`DispatcherEvents`](../interfaces/DispatcherEvents.md) |

#### Parameters

| Name | Type |
| :------ | :------ |
| `event` | `T` |
| `listener` | [`ListenerFn`](../interfaces/ListenerFn.md)<`T`\> |
| `options?` | ``true`` \| `OnOptions` |

#### Returns

[`Dispatcher`](Dispatcher.md) \| `Listener`

#### Inherited from

EventEmitter2.once

#### Defined in

[resources/lib/Dispatcher/Dispatcher.ts:75](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Dispatcher/Dispatcher.ts#L75)

___

### prependAny

▸ **prependAny**(`listener`): [`Dispatcher`](Dispatcher.md)

#### Parameters

| Name | Type |
| :------ | :------ |
| `listener` | `EventAndListener` |

#### Returns

[`Dispatcher`](Dispatcher.md)

#### Inherited from

EventEmitter2.prependAny

#### Defined in

node_modules/eventemitter2/eventemitter2.d.ts:129

___

### prependListener

▸ **prependListener**<`T`\>(`event`, `listener`, `options?`): [`Dispatcher`](Dispatcher.md) \| `Listener`

#### Type parameters

| Name | Type |
| :------ | :------ |
| `T` | extends keyof [`DispatcherEvents`](../interfaces/DispatcherEvents.md) |

#### Parameters

| Name | Type |
| :------ | :------ |
| `event` | `T` |
| `listener` | [`ListenerFn`](../interfaces/ListenerFn.md)<`T`\> |
| `options?` | `boolean` \| `OnOptions` |

#### Returns

[`Dispatcher`](Dispatcher.md) \| `Listener`

#### Inherited from

EventEmitter2.prependListener

#### Defined in

[resources/lib/Dispatcher/Dispatcher.ts:73](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Dispatcher/Dispatcher.ts#L73)

___

### prependMany

▸ **prependMany**<`T`\>(`event`, `timesToListen`, `listener`, `options?`): [`Dispatcher`](Dispatcher.md) \| `Listener`

#### Type parameters

| Name | Type |
| :------ | :------ |
| `T` | extends keyof [`DispatcherEvents`](../interfaces/DispatcherEvents.md) |

#### Parameters

| Name | Type |
| :------ | :------ |
| `event` | `T` |
| `timesToListen` | `number` |
| `listener` | [`ListenerFn`](../interfaces/ListenerFn.md)<`T`\> |
| `options?` | `boolean` \| `OnOptions` |

#### Returns

[`Dispatcher`](Dispatcher.md) \| `Listener`

#### Inherited from

EventEmitter2.prependMany

#### Defined in

[resources/lib/Dispatcher/Dispatcher.ts:81](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Dispatcher/Dispatcher.ts#L81)

___

### prependOnceListener

▸ **prependOnceListener**<`T`\>(`event`, `listener`, `options?`): [`Dispatcher`](Dispatcher.md) \| `Listener`

#### Type parameters

| Name | Type |
| :------ | :------ |
| `T` | extends keyof [`DispatcherEvents`](../interfaces/DispatcherEvents.md) |

#### Parameters

| Name | Type |
| :------ | :------ |
| `event` | `T` |
| `listener` | [`ListenerFn`](../interfaces/ListenerFn.md)<`T`\> |
| `options?` | `boolean` \| `OnOptions` |

#### Returns

[`Dispatcher`](Dispatcher.md) \| `Listener`

#### Inherited from

EventEmitter2.prependOnceListener

#### Defined in

[resources/lib/Dispatcher/Dispatcher.ts:77](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Dispatcher/Dispatcher.ts#L77)

___

### removeAllListeners

▸ **removeAllListeners**(`event?`): [`Dispatcher`](Dispatcher.md)

#### Parameters

| Name | Type |
| :------ | :------ |
| `event?` | keyof [`DispatcherEvents`](../interfaces/DispatcherEvents.md) |

#### Returns

[`Dispatcher`](Dispatcher.md)

#### Inherited from

EventEmitter2.removeAllListeners

#### Defined in

[resources/lib/Dispatcher/Dispatcher.ts:87](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Dispatcher/Dispatcher.ts#L87)

___

### removeListener

▸ **removeListener**<`T`\>(`event`, `listener`): [`Dispatcher`](Dispatcher.md)

#### Type parameters

| Name | Type |
| :------ | :------ |
| `T` | extends keyof [`DispatcherEvents`](../interfaces/DispatcherEvents.md) |

#### Parameters

| Name | Type |
| :------ | :------ |
| `event` | `T` |
| `listener` | [`ListenerFn`](../interfaces/ListenerFn.md)<`T`\> |

#### Returns

[`Dispatcher`](Dispatcher.md)

#### Inherited from

EventEmitter2.removeListener

#### Defined in

[resources/lib/Dispatcher/Dispatcher.ts:83](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Dispatcher/Dispatcher.ts#L83)

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
| `event?` | keyof [`DispatcherEvents`](../interfaces/DispatcherEvents.md) |

#### Returns

`Boolean`

#### Inherited from

EventEmitter2.stopListeningTo

#### Defined in

[resources/lib/Dispatcher/Dispatcher.ts:97](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Dispatcher/Dispatcher.ts#L97)

___

### waitFor

▸ **waitFor**<`T`\>(`event`, `timeout?`): `CancelablePromise`<`any`[]\>

#### Type parameters

| Name | Type |
| :------ | :------ |
| `T` | extends keyof [`DispatcherEvents`](../interfaces/DispatcherEvents.md) |

#### Parameters

| Name | Type |
| :------ | :------ |
| `event` | `T` |
| `timeout?` | `number` |

#### Returns

`CancelablePromise`<`any`[]\>

#### Inherited from

EventEmitter2.waitFor

#### Defined in

[resources/lib/Dispatcher/Dispatcher.ts:91](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Dispatcher/Dispatcher.ts#L91)

▸ **waitFor**<`T`\>(`event`, `filter?`): `CancelablePromise`<`any`[]\>

#### Type parameters

| Name | Type |
| :------ | :------ |
| `T` | extends keyof [`DispatcherEvents`](../interfaces/DispatcherEvents.md) |

#### Parameters

| Name | Type |
| :------ | :------ |
| `event` | `T` |
| `filter?` | `WaitForFilter` |

#### Returns

`CancelablePromise`<`any`[]\>

#### Inherited from

EventEmitter2.waitFor

#### Defined in

[resources/lib/Dispatcher/Dispatcher.ts:93](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Dispatcher/Dispatcher.ts#L93)

▸ **waitFor**<`T`\>(`event`, `options?`): `CancelablePromise`<`any`[]\>

#### Type parameters

| Name | Type |
| :------ | :------ |
| `T` | extends keyof [`DispatcherEvents`](../interfaces/DispatcherEvents.md) |

#### Parameters

| Name | Type |
| :------ | :------ |
| `event` | `T` |
| `options?` | `WaitForOptions` |

#### Returns

`CancelablePromise`<`any`[]\>

#### Inherited from

EventEmitter2.waitFor

#### Defined in

[resources/lib/Dispatcher/Dispatcher.ts:95](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Dispatcher/Dispatcher.ts#L95)

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
