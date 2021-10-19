[Streams Platform Client Api - v1.0.2](../README.md) / [Exports](../modules.md) / IServiceProvider

# Interface: IServiceProvider

## Implemented by

- [`ServiceProvider`](../classes/ServiceProvider.md)

## Table of contents

### Properties

- [app](IServiceProvider.md#app)
- [bindings](IServiceProvider.md#bindings)
- [providers](IServiceProvider.md#providers)
- [singletons](IServiceProvider.md#singletons)

### Methods

- [boot](IServiceProvider.md#boot)
- [register](IServiceProvider.md#register)

## Properties

### app

• **app**: [`Application`](../classes/Application.md)

#### Defined in

[resources/lib/Support/ServiceProvider.ts:21](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Support/ServiceProvider.ts#L21)

___

### bindings

• `Optional` **bindings**: `Record`<`string`, [`Constructor`](../modules.md#constructor)<`any`\>\>

#### Defined in

[resources/lib/Support/ServiceProvider.ts:24](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Support/ServiceProvider.ts#L24)

___

### providers

• `Optional` **providers**: [`IServiceProviderClass`](../modules.md#iserviceproviderclass)[]

#### Defined in

[resources/lib/Support/ServiceProvider.ts:22](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Support/ServiceProvider.ts#L22)

___

### singletons

• `Optional` **singletons**: `Record`<`string`, [`Constructor`](../modules.md#constructor)<`any`\>\>

#### Defined in

[resources/lib/Support/ServiceProvider.ts:23](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Support/ServiceProvider.ts#L23)

## Methods

### boot

▸ `Optional` **boot**(): `any`

#### Returns

`any`

#### Defined in

[resources/lib/Support/ServiceProvider.ts:28](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Support/ServiceProvider.ts#L28)

___

### register

▸ `Optional` **register**(): `any`

#### Returns

`any`

#### Defined in

[resources/lib/Support/ServiceProvider.ts:26](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Support/ServiceProvider.ts#L26)
