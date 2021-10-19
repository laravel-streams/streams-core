[Streams Platform Client Api - v1.0.2](../README.md) / [Exports](../modules.md) / Application

# Class: Application

## Hierarchy

- `Container`

  ↳ **`Application`**

## Table of contents

### Constructors

- [constructor](Application.md#constructor)

### Properties

- [booted](Application.md#booted)
- [config](Application.md#config)
- [events](Application.md#events)
- [http](Application.md#http)
- [id](Application.md#id)
- [loaded](Application.md#loaded)
- [options](Application.md#options)
- [parent](Application.md#parent)
- [providers](Application.md#providers)
- [started](Application.md#started)
- [storage](Application.md#storage)
- [\_instance](Application.md#_instance)

### Accessors

- [instance](Application.md#instance)

### Methods

- [addBindingGetter](Application.md#addbindinggetter)
- [applyCustomMetadataReader](Application.md#applycustommetadatareader)
- [applyMiddleware](Application.md#applymiddleware)
- [bind](Application.md#bind)
- [binding](Application.md#binding)
- [boot](Application.md#boot)
- [createChild](Application.md#createchild)
- [get](Application.md#get)
- [getAll](Application.md#getall)
- [getAllNamed](Application.md#getallnamed)
- [getAllTagged](Application.md#getalltagged)
- [getNamed](Application.md#getnamed)
- [getTagged](Application.md#gettagged)
- [initialize](Application.md#initialize)
- [instance](Application.md#instance)
- [isBooted](Application.md#isbooted)
- [isBound](Application.md#isbound)
- [isBoundNamed](Application.md#isboundnamed)
- [isBoundTagged](Application.md#isboundtagged)
- [isStarted](Application.md#isstarted)
- [load](Application.md#load)
- [loadAsync](Application.md#loadasync)
- [loadProvider](Application.md#loadprovider)
- [loadProviders](Application.md#loadproviders)
- [rebind](Application.md#rebind)
- [register](Application.md#register)
- [registerProviders](Application.md#registerproviders)
- [resolve](Application.md#resolve)
- [restore](Application.md#restore)
- [singleton](Application.md#singleton)
- [snapshot](Application.md#snapshot)
- [start](Application.md#start)
- [unbind](Application.md#unbind)
- [unbindAll](Application.md#unbindall)
- [unload](Application.md#unload)
- [getInstance](Application.md#getinstance)
- [merge](Application.md#merge)

## Constructors

### constructor

• `Private` **new Application**()

Create a new Application instance.

#### Defined in

[resources/lib/Foundation/Application.ts:107](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Foundation/Application.ts#L107)

## Properties

### booted

• `Protected` **booted**: `boolean` = `false`

The booted flag.

#### Defined in

[resources/lib/Foundation/Application.ts:59](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Foundation/Application.ts#L59)

___

### config

• **config**: `Repository`<[`Configuration`](../interfaces/Configuration.md)\> & [`Configuration`](../interfaces/Configuration.md)

#### Defined in

[resources/lib/Foundation/Application.ts:17](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Foundation/Application.ts#L17)

___

### events

• **events**: [`Dispatcher`](Dispatcher.md)

#### Defined in

[resources/lib/Foundation/Application.ts:16](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Foundation/Application.ts#L16)

___

### http

• **http**: `AxiosInstance`

#### Defined in

[resources/lib/Http/HttpServiceProvider.ts:80](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Http/HttpServiceProvider.ts#L80)

___

### id

• **id**: `number`

#### Defined in

node_modules/inversify/lib/container/container.d.ts:3

___

### loaded

• `Protected` **loaded**: `Object` = `{}`

Loaded service providers.

#### Defined in

[resources/lib/Foundation/Application.ts:54](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Foundation/Application.ts#L54)

___

### options

• `Readonly` **options**: `ContainerOptions`

#### Defined in

node_modules/inversify/lib/container/container.d.ts:5

___

### parent

• **parent**: `Container`

#### Defined in

node_modules/inversify/lib/container/container.d.ts:4

___

### providers

• `Protected` **providers**: `any`[] = `[]`

Configured service providers.

#### Defined in

[resources/lib/Foundation/Application.ts:49](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Foundation/Application.ts#L49)

___

### started

• `Protected` **started**: `boolean` = `false`

The started flag.

#### Defined in

[resources/lib/Foundation/Application.ts:64](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Foundation/Application.ts#L64)

___

### storage

• **storage**: [`StorageAdapterInterface`](../interfaces/StorageAdapterInterface.md)

#### Defined in

[resources/lib/Storage/StorageServiceProvider.ts:19](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Storage/StorageServiceProvider.ts#L19)

___

### \_instance

▪ `Static` `Protected` **\_instance**: [`Application`](Application.md)

The application instance.

#### Defined in

[resources/lib/Foundation/Application.ts:44](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Foundation/Application.ts#L44)

## Accessors

### instance

• `Static` `get` **instance**(): [`Application`](Application.md)

Get/create the instance.

#### Returns

[`Application`](Application.md)

#### Defined in

[resources/lib/Foundation/Application.ts:69](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Foundation/Application.ts#L69)

## Methods

### addBindingGetter

▸ **addBindingGetter**(`id`, `key?`): [`Application`](Application.md)

Add a getter for the binding.

#### Parameters

| Name | Type | Default value |
| :------ | :------ | :------ |
| `id` | `string` | `undefined` |
| `key` | `string` | `null` |

#### Returns

[`Application`](Application.md)

#### Defined in

[resources/lib/Foundation/Application.ts:396](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Foundation/Application.ts#L396)

___

### applyCustomMetadataReader

▸ **applyCustomMetadataReader**(`metadataReader`): `void`

#### Parameters

| Name | Type |
| :------ | :------ |
| `metadataReader` | `MetadataReader` |

#### Returns

`void`

#### Defined in

node_modules/inversify/lib/container/container.d.ts:27

___

### applyMiddleware

▸ **applyMiddleware**(...`middlewares`): `void`

#### Parameters

| Name | Type |
| :------ | :------ |
| `...middlewares` | `Middleware`[] |

#### Returns

`void`

#### Defined in

node_modules/inversify/lib/container/container.d.ts:26

___

### bind

▸ **bind**<`T`\>(`serviceIdentifier`): `BindingToSyntax`<`T`\>

#### Type parameters

| Name |
| :------ |
| `T` |

#### Parameters

| Name | Type |
| :------ | :------ |
| `serviceIdentifier` | `ServiceIdentifier`<`T`\> |

#### Returns

`BindingToSyntax`<`T`\>

#### Defined in

node_modules/inversify/lib/container/container.d.ts:16

___

### binding

▸ **binding**<`Type`\>(`serviceIdentifier`, `func`, `singleton?`): [`Application`](Application.md)

Register a binding.

#### Type parameters

| Name |
| :------ |
| `Type` |

#### Parameters

| Name | Type | Default value |
| :------ | :------ | :------ |
| `serviceIdentifier` | `ServiceIdentifier`<`Type`\> | `undefined` |
| `func` | (`app`: [`Application`](Application.md)) => `Type` | `undefined` |
| `singleton` | `boolean` | `false` |

#### Returns

[`Application`](Application.md)

#### Defined in

[resources/lib/Foundation/Application.ts:359](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Foundation/Application.ts#L359)

___

### boot

▸ **boot**(): `Promise`<[`Application`](Application.md)\>

Boot the application.

#### Returns

`Promise`<[`Application`](Application.md)\>

#### Defined in

[resources/lib/Foundation/Application.ts:167](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Foundation/Application.ts#L167)

___

### createChild

▸ **createChild**(`containerOptions?`): `Container`

#### Parameters

| Name | Type |
| :------ | :------ |
| `containerOptions?` | `ContainerOptions` |

#### Returns

`Container`

#### Defined in

node_modules/inversify/lib/container/container.d.ts:25

___

### get

▸ **get**<`T`\>(`serviceIdentifier`): `T`

#### Type parameters

| Name |
| :------ |
| `T` |

#### Parameters

| Name | Type |
| :------ | :------ |
| `serviceIdentifier` | `ServiceIdentifier`<`T`\> |

#### Returns

`T`

#### Defined in

node_modules/inversify/lib/container/container.d.ts:28

___

### getAll

▸ **getAll**<`T`\>(`serviceIdentifier`): `T`[]

#### Type parameters

| Name |
| :------ |
| `T` |

#### Parameters

| Name | Type |
| :------ | :------ |
| `serviceIdentifier` | `ServiceIdentifier`<`T`\> |

#### Returns

`T`[]

#### Defined in

node_modules/inversify/lib/container/container.d.ts:31

___

### getAllNamed

▸ **getAllNamed**<`T`\>(`serviceIdentifier`, `named`): `T`[]

#### Type parameters

| Name |
| :------ |
| `T` |

#### Parameters

| Name | Type |
| :------ | :------ |
| `serviceIdentifier` | `ServiceIdentifier`<`T`\> |
| `named` | `string` \| `number` \| `symbol` |

#### Returns

`T`[]

#### Defined in

node_modules/inversify/lib/container/container.d.ts:33

___

### getAllTagged

▸ **getAllTagged**<`T`\>(`serviceIdentifier`, `key`, `value`): `T`[]

#### Type parameters

| Name |
| :------ |
| `T` |

#### Parameters

| Name | Type |
| :------ | :------ |
| `serviceIdentifier` | `ServiceIdentifier`<`T`\> |
| `key` | `string` \| `number` \| `symbol` |
| `value` | `any` |

#### Returns

`T`[]

#### Defined in

node_modules/inversify/lib/container/container.d.ts:32

___

### getNamed

▸ **getNamed**<`T`\>(`serviceIdentifier`, `named`): `T`

#### Type parameters

| Name |
| :------ |
| `T` |

#### Parameters

| Name | Type |
| :------ | :------ |
| `serviceIdentifier` | `ServiceIdentifier`<`T`\> |
| `named` | `string` \| `number` \| `symbol` |

#### Returns

`T`

#### Defined in

node_modules/inversify/lib/container/container.d.ts:30

___

### getTagged

▸ **getTagged**<`T`\>(`serviceIdentifier`, `key`, `value`): `T`

#### Type parameters

| Name |
| :------ |
| `T` |

#### Parameters

| Name | Type |
| :------ | :------ |
| `serviceIdentifier` | `ServiceIdentifier`<`T`\> |
| `key` | `string` \| `number` \| `symbol` |
| `value` | `any` |

#### Returns

`T`

#### Defined in

node_modules/inversify/lib/container/container.d.ts:29

___

### initialize

▸ **initialize**(`options?`): `Promise`<[`Application`](Application.md)\>

Initialize the application.

#### Parameters

| Name | Type |
| :------ | :------ |
| `options` | [`ApplicationInitOptions`](../interfaces/ApplicationInitOptions.md) |

#### Returns

`Promise`<[`Application`](Application.md)\>

#### Defined in

[resources/lib/Foundation/Application.ts:128](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Foundation/Application.ts#L128)

___

### instance

▸ **instance**<`Type`\>(`serviceIdentifier`, `value`): [`Application`](Application.md)

Register an instance binding.

#### Type parameters

| Name |
| :------ |
| `Type` |

#### Parameters

| Name | Type |
| :------ | :------ |
| `serviceIdentifier` | `ServiceIdentifier`<`Type`\> |
| `value` | `Type` |

#### Returns

[`Application`](Application.md)

#### Defined in

[resources/lib/Foundation/Application.ts:379](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Foundation/Application.ts#L379)

___

### isBooted

▸ **isBooted**(): `boolean`

Return whether the
application has booted.

#### Returns

`boolean`

bool

#### Defined in

[resources/lib/Foundation/Application.ts:94](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Foundation/Application.ts#L94)

___

### isBound

▸ **isBound**(`serviceIdentifier`): `boolean`

#### Parameters

| Name | Type |
| :------ | :------ |
| `serviceIdentifier` | `ServiceIdentifier`<`any`\> |

#### Returns

`boolean`

#### Defined in

node_modules/inversify/lib/container/container.d.ts:20

___

### isBoundNamed

▸ **isBoundNamed**(`serviceIdentifier`, `named`): `boolean`

#### Parameters

| Name | Type |
| :------ | :------ |
| `serviceIdentifier` | `ServiceIdentifier`<`any`\> |
| `named` | `string` \| `number` \| `symbol` |

#### Returns

`boolean`

#### Defined in

node_modules/inversify/lib/container/container.d.ts:21

___

### isBoundTagged

▸ **isBoundTagged**(`serviceIdentifier`, `key`, `value`): `boolean`

#### Parameters

| Name | Type |
| :------ | :------ |
| `serviceIdentifier` | `ServiceIdentifier`<`any`\> |
| `key` | `string` \| `number` \| `symbol` |
| `value` | `any` |

#### Returns

`boolean`

#### Defined in

node_modules/inversify/lib/container/container.d.ts:22

___

### isStarted

▸ **isStarted**(): `boolean`

Return whether the
application has started.

#### Returns

`boolean`

bool

#### Defined in

[resources/lib/Foundation/Application.ts:102](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Foundation/Application.ts#L102)

___

### load

▸ **load**(...`modules`): `void`

#### Parameters

| Name | Type |
| :------ | :------ |
| `...modules` | `ContainerModule`[] |

#### Returns

`void`

#### Defined in

node_modules/inversify/lib/container/container.d.ts:13

___

### loadAsync

▸ **loadAsync**(...`modules`): `Promise`<`void`\>

#### Parameters

| Name | Type |
| :------ | :------ |
| `...modules` | `AsyncContainerModule`[] |

#### Returns

`Promise`<`void`\>

#### Defined in

node_modules/inversify/lib/container/container.d.ts:14

___

### loadProvider

▸ `Protected` **loadProvider**(`Provider`): `Promise`<[`IServiceProvider`](../interfaces/IServiceProvider.md)\>

Load the given provider.

#### Parameters

| Name | Type |
| :------ | :------ |
| `Provider` | [`IServiceProviderClass`](../modules.md#iserviceproviderclass) |

#### Returns

`Promise`<[`IServiceProvider`](../interfaces/IServiceProvider.md)\>

#### Defined in

[resources/lib/Foundation/Application.ts:246](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Foundation/Application.ts#L246)

___

### loadProviders

▸ `Protected` **loadProviders**(`Providers`): `Promise`<[`Application`](Application.md)\>

Load service providers.

#### Parameters

| Name | Type |
| :------ | :------ |
| `Providers` | [`IServiceProviderClass`](../modules.md#iserviceproviderclass)[] |

#### Returns

`Promise`<[`Application`](Application.md)\>

#### Defined in

[resources/lib/Foundation/Application.ts:231](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Foundation/Application.ts#L231)

___

### rebind

▸ **rebind**<`T`\>(`serviceIdentifier`): `BindingToSyntax`<`T`\>

#### Type parameters

| Name |
| :------ |
| `T` |

#### Parameters

| Name | Type |
| :------ | :------ |
| `serviceIdentifier` | `ServiceIdentifier`<`T`\> |

#### Returns

`BindingToSyntax`<`T`\>

#### Defined in

node_modules/inversify/lib/container/container.d.ts:17

___

### register

▸ **register**(`Provider`): `Promise`<[`Application`](Application.md)\>

Register a Service Provider, if not instantiated, it will load the providers instance.

**`see`** IServiceProvider

**`see`** IServiceProviderClass

**`see`** loadProvider

#### Parameters

| Name | Type |
| :------ | :------ |
| `Provider` | [`IServiceProviderClass`](../modules.md#iserviceproviderclass) \| [`IServiceProvider`](../interfaces/IServiceProvider.md) |

#### Returns

`Promise`<[`Application`](Application.md)\>

#### Defined in

[resources/lib/Foundation/Application.ts:312](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Foundation/Application.ts#L312)

___

### registerProviders

▸ `Protected` **registerProviders**(`providers`): `Promise`<[`Application`](Application.md)\>

Register all given providers.

#### Parameters

| Name | Type | Description |
| :------ | :------ | :------ |
| `providers` | [`IServiceProvider`](../interfaces/IServiceProvider.md)[] | An array of instantiated providers |

#### Returns

`Promise`<[`Application`](Application.md)\>

this

#### Defined in

[resources/lib/Foundation/Application.ts:293](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Foundation/Application.ts#L293)

___

### resolve

▸ **resolve**<`T`\>(`constructorFunction`): `T`

#### Type parameters

| Name |
| :------ |
| `T` |

#### Parameters

| Name | Type |
| :------ | :------ |
| `constructorFunction` | `Newable`<`T`\> |

#### Returns

`T`

#### Defined in

node_modules/inversify/lib/container/container.d.ts:34

___

### restore

▸ **restore**(): `void`

#### Returns

`void`

#### Defined in

node_modules/inversify/lib/container/container.d.ts:24

___

### singleton

▸ **singleton**<`Type`\>(`serviceIdentifier`, `constructor`): [`Application`](Application.md)

Register a singleton bindng.

#### Type parameters

| Name |
| :------ |
| `Type` |

#### Parameters

| Name | Type |
| :------ | :------ |
| `serviceIdentifier` | `ServiceIdentifier`<`Type`\> |
| `constructor` | (...`args`: `any`[]) => `Type` |

#### Returns

[`Application`](Application.md)

#### Defined in

[resources/lib/Foundation/Application.ts:341](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Foundation/Application.ts#L341)

___

### snapshot

▸ **snapshot**(): `void`

#### Returns

`void`

#### Defined in

node_modules/inversify/lib/container/container.d.ts:23

___

### start

▸ **start**(...`args`): `Promise`<[`Application`](Application.md)\>

Start the application.

#### Parameters

| Name | Type |
| :------ | :------ |
| `...args` | `any`[] |

#### Returns

`Promise`<[`Application`](Application.md)\>

#### Defined in

[resources/lib/Foundation/Application.ts:205](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Foundation/Application.ts#L205)

___

### unbind

▸ **unbind**(`serviceIdentifier`): `void`

#### Parameters

| Name | Type |
| :------ | :------ |
| `serviceIdentifier` | `ServiceIdentifier`<`any`\> |

#### Returns

`void`

#### Defined in

node_modules/inversify/lib/container/container.d.ts:18

___

### unbindAll

▸ **unbindAll**(): `void`

#### Returns

`void`

#### Defined in

node_modules/inversify/lib/container/container.d.ts:19

___

### unload

▸ **unload**(...`modules`): `void`

#### Parameters

| Name | Type |
| :------ | :------ |
| `...modules` | `ContainerModule`[] |

#### Returns

`void`

#### Defined in

node_modules/inversify/lib/container/container.d.ts:15

___

### getInstance

▸ `Static` **getInstance**(): [`Application`](Application.md)

Return a singleton
instance of Application

#### Returns

[`Application`](Application.md)

#### Defined in

[resources/lib/Foundation/Application.ts:84](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Foundation/Application.ts#L84)

___

### merge

▸ `Static` **merge**(`container1`, `container2`, ...`container3`): `Container`

#### Parameters

| Name | Type |
| :------ | :------ |
| `container1` | `Container` |
| `container2` | `Container` |
| `...container3` | `Container`[] |

#### Returns

`Container`

#### Defined in

node_modules/inversify/lib/container/container.d.ts:11
