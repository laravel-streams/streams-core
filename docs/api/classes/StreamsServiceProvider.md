[Streams Platform Client Api - v1.0.2](../README.md) / [Exports](../modules.md) / StreamsServiceProvider

# Class: StreamsServiceProvider

## Hierarchy

- [`ServiceProvider`](ServiceProvider.md)

  ↳ **`StreamsServiceProvider`**

## Table of contents

### Constructors

- [constructor](StreamsServiceProvider.md#constructor)

### Properties

- [app](StreamsServiceProvider.md#app)

### Methods

- [register](StreamsServiceProvider.md#register)

## Constructors

### constructor

• **new StreamsServiceProvider**(`app`)

Create a new ServiceProvider instance.

#### Parameters

| Name | Type |
| :------ | :------ |
| `app` | [`Application`](Application.md) |

#### Inherited from

[ServiceProvider](ServiceProvider.md).[constructor](ServiceProvider.md#constructor)

#### Defined in

[resources/lib/Support/ServiceProvider.ts:10](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Support/ServiceProvider.ts#L10)

## Properties

### app

• **app**: [`Application`](Application.md)

#### Inherited from

[ServiceProvider](ServiceProvider.md).[app](ServiceProvider.md#app)

## Methods

### register

▸ **register**(): `void`

Register the service.

#### Returns

`void`

#### Defined in

[resources/lib/Streams/StreamsServiceProvider.ts:11](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Streams/StreamsServiceProvider.ts#L11)
