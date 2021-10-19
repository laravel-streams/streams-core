[Streams Platform Client Api - v1.0.2](../README.md) / [Exports](../modules.md) / ListenerFn

# Interface: ListenerFn<T\>

## Type parameters

| Name | Type |
| :------ | :------ |
| `T` | extends keyof [`DispatcherEvents`](DispatcherEvents.md) |

## Callable

### ListenerFn

▸ **ListenerFn**(...`values`): `void`

#### Parameters

| Name | Type |
| :------ | :------ |
| `...values` | [`DispatcherEvents`](DispatcherEvents.md)[`T`] |

#### Returns

`void`

#### Defined in

[resources/lib/Dispatcher/Dispatcher.ts:61](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Dispatcher/Dispatcher.ts#L61)
