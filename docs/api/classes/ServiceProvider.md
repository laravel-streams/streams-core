[Streams Platform Client Api - v1.0.2](../README.md) / [Exports](../modules.md) / ServiceProvider

# Class: ServiceProvider

## Hierarchy

- **`ServiceProvider`**

  ↳ [`HttpServiceProvider`](HttpServiceProvider.md)

  ↳ [`StorageServiceProvider`](StorageServiceProvider.md)

  ↳ [`StreamsServiceProvider`](StreamsServiceProvider.md)

  ↳ [`CoreServiceProvider`](CoreServiceProvider.md)

## Implements

- [`IServiceProvider`](../interfaces/IServiceProvider.md)

## Table of contents

### Constructors

- [constructor](ServiceProvider.md#constructor)

### Properties

- [app](ServiceProvider.md#app)

## Constructors

### constructor

• **new ServiceProvider**(`app`)

Create a new ServiceProvider instance.

#### Parameters

| Name | Type |
| :------ | :------ |
| `app` | [`Application`](Application.md) |

#### Defined in

[resources/lib/Support/ServiceProvider.ts:10](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Support/ServiceProvider.ts#L10)

## Properties

### app

• **app**: [`Application`](Application.md)

#### Implementation of

[IServiceProvider](../interfaces/IServiceProvider.md).[app](../interfaces/IServiceProvider.md#app)
