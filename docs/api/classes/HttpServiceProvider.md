[Streams Platform Client Api - v1.0.2](../README.md) / [Exports](../modules.md) / HttpServiceProvider

# Class: HttpServiceProvider

## Hierarchy

- [`ServiceProvider`](ServiceProvider.md)

  ↳ **`HttpServiceProvider`**

## Table of contents

### Constructors

- [constructor](HttpServiceProvider.md#constructor)

### Properties

- [app](HttpServiceProvider.md#app)

### Methods

- [boot](HttpServiceProvider.md#boot)
- [bootETag](HttpServiceProvider.md#bootetag)
- [register](HttpServiceProvider.md#register)
- [registerAxios](HttpServiceProvider.md#registeraxios)

## Constructors

### constructor

• **new HttpServiceProvider**(`app`)

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

### boot

▸ **boot**(): `void`

#### Returns

`void`

#### Defined in

[resources/lib/Http/HttpServiceProvider.ts:15](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Http/HttpServiceProvider.ts#L15)

___

### bootETag

▸ `Protected` **bootETag**(): `void`

#### Returns

`void`

#### Defined in

[resources/lib/Http/HttpServiceProvider.ts:59](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Http/HttpServiceProvider.ts#L59)

___

### register

▸ **register**(): `void`

Register the service.

#### Returns

`void`

#### Defined in

[resources/lib/Http/HttpServiceProvider.ts:11](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Http/HttpServiceProvider.ts#L11)

___

### registerAxios

▸ `Protected` **registerAxios**(): `void`

#### Returns

`void`

#### Defined in

[resources/lib/Http/HttpServiceProvider.ts:19](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Http/HttpServiceProvider.ts#L19)
