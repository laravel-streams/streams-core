[Streams Platform Client Api - v1.0.2](../README.md) / [Exports](../modules.md) / CoreServiceProvider

# Class: CoreServiceProvider

## Hierarchy

- [`ServiceProvider`](ServiceProvider.md)

  ↳ **`CoreServiceProvider`**

## Table of contents

### Constructors

- [constructor](CoreServiceProvider.md#constructor)

### Properties

- [app](CoreServiceProvider.md#app)
- [providers](CoreServiceProvider.md#providers)

## Constructors

### constructor

• **new CoreServiceProvider**(`app`)

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

___

### providers

• **providers**: typeof [`StorageServiceProvider`](StorageServiceProvider.md)[]

#### Defined in

[resources/lib/CoreServiceProvider.ts:7](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/CoreServiceProvider.ts#L7)
