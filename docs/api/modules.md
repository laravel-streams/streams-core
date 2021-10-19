[Streams Platform Client Api - v1.0.2](README.md) / Exports


# Streams Platform Client Api - v1.0.2

## Table of contents

### Namespaces

- [Http](modules/Http.md)
- [entries](modules/entries.md)
- [fields](modules/fields.md)
- [streams](modules/streams.md)
- [ui](modules/ui.md)

### Classes

- [Application](classes/Application.md)
- [Collection](classes/Collection.md)
- [CoreServiceProvider](classes/CoreServiceProvider.md)
- [Criteria](classes/Criteria.md)
- [Dispatcher](classes/Dispatcher.md)
- [Entry](classes/Entry.md)
- [EntryCollection](classes/EntryCollection.md)
- [Field](classes/Field.md)
- [FieldCollection](classes/FieldCollection.md)
- [Http](classes/Http.md)
- [HttpServiceProvider](classes/HttpServiceProvider.md)
- [LocalStorageAdapter](classes/LocalStorageAdapter.md)
- [PaginatedEntryCollection](classes/PaginatedEntryCollection.md)
- [Repository](classes/Repository.md)
- [ServiceProvider](classes/ServiceProvider.md)
- [SessionStorageAdapter](classes/SessionStorageAdapter.md)
- [StorageAdapter](classes/StorageAdapter.md)
- [StorageServiceProvider](classes/StorageServiceProvider.md)
- [Stream](classes/Stream.md)
- [Streams](classes/Streams.md)
- [StreamsServiceProvider](classes/StreamsServiceProvider.md)
- [Transformer](classes/Transformer.md)

### Interfaces

- [ApplicationInitOptions](interfaces/ApplicationInitOptions.md)
- [Configuration](interfaces/Configuration.md)
- [CriteriaParameter](interfaces/CriteriaParameter.md)
- [DispatcherEvents](interfaces/DispatcherEvents.md)
- [HttpConfiguration](interfaces/HttpConfiguration.md)
- [IBaseStream](interfaces/IBaseStream.md)
- [IEntries](interfaces/IEntries.md)
- [IEntriesMeta](interfaces/IEntriesMeta.md)
- [IPaginatedEntriesMeta](interfaces/IPaginatedEntriesMeta.md)
- [IServiceProvider](interfaces/IServiceProvider.md)
- [IStream](interfaces/IStream.md)
- [IStreamMeta](interfaces/IStreamMeta.md)
- [IStreamResponse](interfaces/IStreamResponse.md)
- [IStreams](interfaces/IStreams.md)
- [ListenerFn](interfaces/ListenerFn.md)
- [StorageAdapterInterface](interfaces/StorageAdapterInterface.md)
- [StreamsConfiguration](interfaces/StreamsConfiguration.md)

### Type aliases

- [ComparisonOperator](modules.md#comparisonoperator)
- [Config](modules.md#config)
- [Constructor](modules.md#constructor)
- [DispatcherEvent](modules.md#dispatcherevent)
- [IEntriesLinks](modules.md#ientrieslinks)
- [IEntry](modules.md#ientry)
- [IPaginatedEntriesLinks](modules.md#ipaginatedentrieslinks)
- [IServiceProviderClass](modules.md#iserviceproviderclass)
- [IStreamLinks](modules.md#istreamlinks)
- [LogicalOperator](modules.md#logicaloperator)
- [Operator](modules.md#operator)
- [OrderByDirection](modules.md#orderbydirection)

### Variables

- [app](modules.md#app)
- [comparisonOperators](modules.md#comparisonoperators)
- [logicalOperators](modules.md#logicaloperators)
- [operators](modules.md#operators)

### Functions

- [inject](modules.md#inject)

## Type aliases

### ComparisonOperator

Ƭ **ComparisonOperator**: ``">"`` \| ``"<"`` \| ``"=="`` \| ``"!="`` \| ``">="`` \| ``"<="`` \| ``"!<"`` \| ``"!>"`` \| ``"<>"``

#### Defined in

[resources/lib/Streams/Criteria.ts:12](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Streams/Criteria.ts#L12)

___

### Config

Ƭ **Config**: `Repository`<[`Configuration`](interfaces/Configuration.md)\> & [`Configuration`](interfaces/Configuration.md)

#### Defined in

[resources/lib/types/config.ts:6](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/types/config.ts#L6)

___

### Constructor

Ƭ **Constructor**<`Type`\>: (...`args`: `any`[]) => `Type`

#### Type parameters

| Name | Type |
| :------ | :------ |
| `Type` | `any` |

#### Type declaration

• (...`args`)

##### Parameters

| Name | Type |
| :------ | :------ |
| `...args` | `any`[] |

#### Defined in

[resources/lib/Support/ServiceProvider.ts:13](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Support/ServiceProvider.ts#L13)

___

### DispatcherEvent

Ƭ **DispatcherEvent**: keyof [`DispatcherEvents`](interfaces/DispatcherEvents.md)

#### Defined in

[resources/lib/Dispatcher/Dispatcher.ts:58](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Dispatcher/Dispatcher.ts#L58)

___

### IEntriesLinks

Ƭ **IEntriesLinks**: [`IStreamLinks`](modules.md#istreamlinks)<``"self"`` \| ``"streams"`` \| ``"stream"``\>

#### Defined in

[resources/lib/Streams/EntryCollection.ts:8](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Streams/EntryCollection.ts#L8)

___

### IEntry

Ƭ **IEntry**<`T`, `ID`\>: [`Entry`](classes/Entry.md)<`ID`\> & `T`

#### Type parameters

| Name | Type |
| :------ | :------ |
| `T` | `T` |
| `ID` | extends `string``string` |

#### Defined in

[resources/lib/Streams/Entry.ts:8](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Streams/Entry.ts#L8)

___

### IPaginatedEntriesLinks

Ƭ **IPaginatedEntriesLinks**: [`IStreamLinks`](modules.md#istreamlinks)<``"next_page"`` \| ``"previous_page"`` \| ``"self"`` \| ``"first_page"`` \| ``"streams"`` \| ``"stream"``\>

#### Defined in

[resources/lib/Streams/EntryCollection.ts:9](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Streams/EntryCollection.ts#L9)

___

### IServiceProviderClass

Ƭ **IServiceProviderClass**: `Object`

#### Defined in

[resources/lib/Support/ServiceProvider.ts:15](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Support/ServiceProvider.ts#L15)

___

### IStreamLinks

Ƭ **IStreamLinks**<`K`\>: { [T in keyof K]: string }

#### Type parameters

| Name |
| :------ |
| `K` |

#### Defined in

[resources/lib/types/streams.ts:8](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/types/streams.ts#L8)

___

### LogicalOperator

Ƭ **LogicalOperator**: ``"BETWEEN"`` \| ``"EXISTS"`` \| ``"OR"`` \| ``"AND"`` \| ``"NOT"`` \| ``"IN"`` \| ``"ALL"`` \| ``"ANY"`` \| ``"LIKE"`` \| ``"IS NULL"`` \| ``"UNIQUE"``

#### Defined in

[resources/lib/Streams/Criteria.ts:25](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Streams/Criteria.ts#L25)

___

### Operator

Ƭ **Operator**: [`ComparisonOperator`](modules.md#comparisonoperator) \| [`LogicalOperator`](modules.md#logicaloperator)

#### Defined in

[resources/lib/Streams/Criteria.ts:42](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Streams/Criteria.ts#L42)

___

### OrderByDirection

Ƭ **OrderByDirection**: ``"asc"`` \| ``"desc"``

#### Defined in

[resources/lib/Streams/Criteria.ts:10](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Streams/Criteria.ts#L10)

## Variables

### app

• **app**: [`Application`](classes/Application.md)

#### Defined in

[resources/lib/Foundation/Application.ts:414](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Foundation/Application.ts#L414)

___

### comparisonOperators

• **comparisonOperators**: [`ComparisonOperator`](modules.md#comparisonoperator)[]

#### Defined in

[resources/lib/Streams/Criteria.ts:23](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Streams/Criteria.ts#L23)

___

### logicalOperators

• **logicalOperators**: [`LogicalOperator`](modules.md#logicaloperator)[]

#### Defined in

[resources/lib/Streams/Criteria.ts:38](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Streams/Criteria.ts#L38)

___

### operators

• **operators**: [`Operator`](modules.md#operator)[]

#### Defined in

[resources/lib/Streams/Criteria.ts:40](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Streams/Criteria.ts#L40)

## Functions

### inject

▸ **inject**(`serviceIdentifier`): (`proto`: `any`, `key`: `string`) => `void`

#### Parameters

| Name | Type |
| :------ | :------ |
| `serviceIdentifier` | `string` \| `symbol` \| `Newable`<`any`\> \| `Abstract`<`any`\> |

#### Returns

`fn`

▸ (`proto`, `key`): `void`

##### Parameters

| Name | Type |
| :------ | :------ |
| `proto` | `any` |
| `key` | `string` |

##### Returns

`void`

#### Defined in

node_modules/inversify-inject-decorators/dts/index.d.ts:3
