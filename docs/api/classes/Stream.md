[Streams Platform Client Api - v1.0.2](../README.md) / [Exports](../modules.md) / Stream

# Class: Stream<ID\>

## Type parameters

| Name | Type |
| :------ | :------ |
| `ID` | extends `string``string` |

## Hierarchy

- `Omit`<[`IBaseStream`](../interfaces/IBaseStream.md)<`ID`\>, ``"fields"``\>

  ↳ **`Stream`**

## Table of contents

### Constructors

- [constructor](Stream.md#constructor)

### Properties

- [\_\_toString](Stream.md#__tostring)
- [\_repository](Stream.md#_repository)
- [\_rules](Stream.md#_rules)
- [\_validators](Stream.md#_validators)
- [cache](Stream.md#cache)
- [cached](Stream.md#cached)
- [config](Stream.md#config)
- [created\_at](Stream.md#created_at)
- [extendInput](Stream.md#extendinput)
- [fields](Stream.md#fields)
- [fieldsInput](Stream.md#fieldsinput)
- [flush](Stream.md#flush)
- [forget](Stream.md#forget)
- [id](Stream.md#id)
- [importInput](Stream.md#importinput)
- [isRequired](Stream.md#isrequired)
- [jsonSerialize](Stream.md#jsonserialize)
- [links](Stream.md#links)
- [merge](Stream.md#merge)
- [meta](Stream.md#meta)
- [name](Stream.md#name)
- [normalizeInput](Stream.md#normalizeinput)
- [onInitialized](Stream.md#oninitialized)
- [onInitializing](Stream.md#oninitializing)
- [rules](Stream.md#rules)
- [source](Stream.md#source)
- [toArray](Stream.md#toarray)
- [toJson](Stream.md#tojson)
- [updated\_at](Stream.md#updated_at)

### Accessors

- [repository](Stream.md#repository)

### Methods

- [entries](Stream.md#entries)

## Constructors

### constructor

• **new Stream**<`ID`\>(`stream`, `meta?`, `links?`)

Create a new stream instance.

#### Type parameters

| Name | Type |
| :------ | :------ |
| `ID` | extends `string``string` |

#### Parameters

| Name | Type |
| :------ | :------ |
| `stream` | [`IBaseStream`](../interfaces/IBaseStream.md)<`ID`\> |
| `meta?` | [`IStreamMeta`](../interfaces/IStreamMeta.md) |
| `links?` | [`IStreamLinks`](../modules.md#istreamlinks)<``"entries"`` \| ``"self"``\> |

#### Inherited from

Omit<IBaseStream<ID\>, 'fields'\>.constructor

#### Defined in

[resources/lib/Streams/Stream.ts:17](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Streams/Stream.ts#L17)

## Properties

### \_\_toString

• **\_\_toString**: `any`

#### Defined in

[resources/lib/Streams/Stream.ts:87](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Streams/Stream.ts#L87)

___

### \_repository

• `Protected` **\_repository**: [`Repository`](Repository.md)<`ID`\>

The repository instance.

#### Defined in

[resources/lib/Streams/Stream.ts:34](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Streams/Stream.ts#L34)

___

### \_rules

• `Protected` **\_rules**: `any`[]

Stream validation rules.

#### Defined in

[resources/lib/Streams/Stream.ts:39](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Streams/Stream.ts#L39)

___

### \_validators

• `Protected` **\_validators**: `any`[]

Custom stream validators.

#### Defined in

[resources/lib/Streams/Stream.ts:44](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Streams/Stream.ts#L44)

___

### cache

• **cache**: `any`

#### Defined in

[resources/lib/Streams/Stream.ts:81](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Streams/Stream.ts#L81)

___

### cached

• **cached**: `any`

#### Defined in

[resources/lib/Streams/Stream.ts:80](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Streams/Stream.ts#L80)

___

### config

• **config**: `any`

#### Defined in

[resources/lib/Streams/Stream.ts:79](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Streams/Stream.ts#L79)

___

### created\_at

• **created\_at**: `string`

#### Inherited from

Omit.created\_at

#### Defined in

[resources/lib/types/streams.ts:21](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/types/streams.ts#L21)

___

### extendInput

• **extendInput**: `any`

#### Defined in

[resources/lib/Streams/Stream.ts:90](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Streams/Stream.ts#L90)

___

### fields

• **fields**: `Map`<`string`, [`Field`](Field.md)\>

The stream fields.

#### Defined in

[resources/lib/Streams/Stream.ts:49](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Streams/Stream.ts#L49)

___

### fieldsInput

• **fieldsInput**: `any`

#### Defined in

[resources/lib/Streams/Stream.ts:93](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Streams/Stream.ts#L93)

___

### flush

• **flush**: `any`

#### Defined in

[resources/lib/Streams/Stream.ts:83](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Streams/Stream.ts#L83)

___

### forget

• **forget**: `any`

#### Defined in

[resources/lib/Streams/Stream.ts:82](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Streams/Stream.ts#L82)

___

### id

• **id**: `ID`

#### Inherited from

Omit.id

#### Defined in

[resources/lib/types/streams.ts:20](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/types/streams.ts#L20)

___

### importInput

• **importInput**: `any`

#### Defined in

[resources/lib/Streams/Stream.ts:91](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Streams/Stream.ts#L91)

___

### isRequired

• **isRequired**: `any`

#### Defined in

[resources/lib/Streams/Stream.ts:78](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Streams/Stream.ts#L78)

___

### jsonSerialize

• **jsonSerialize**: `any`

#### Defined in

[resources/lib/Streams/Stream.ts:86](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Streams/Stream.ts#L86)

___

### links

• `Optional` `Readonly` **links**: [`IStreamLinks`](../modules.md#istreamlinks)<``"entries"`` \| ``"self"``\>

___

### merge

• **merge**: `any`

#### Defined in

[resources/lib/Streams/Stream.ts:94](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Streams/Stream.ts#L94)

___

### meta

• `Optional` `Readonly` **meta**: [`IStreamMeta`](../interfaces/IStreamMeta.md)

___

### name

• **name**: `string`

#### Inherited from

Omit.name

#### Defined in

[resources/lib/types/streams.ts:23](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/types/streams.ts#L23)

___

### normalizeInput

• **normalizeInput**: `any`

#### Defined in

[resources/lib/Streams/Stream.ts:92](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Streams/Stream.ts#L92)

___

### onInitialized

• **onInitialized**: `any`

#### Defined in

[resources/lib/Streams/Stream.ts:89](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Streams/Stream.ts#L89)

___

### onInitializing

• **onInitializing**: `any`

#### Defined in

[resources/lib/Streams/Stream.ts:88](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Streams/Stream.ts#L88)

___

### rules

• `Optional` **rules**: `Record`<`string`, `string` \| `object`\>

#### Inherited from

Omit.rules

#### Defined in

[resources/lib/types/streams.ts:29](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/types/streams.ts#L29)

___

### source

• **source**: `Object`

#### Index signature

▪ [key: `string`]: `any`

#### Type declaration

| Name | Type |
| :------ | :------ |
| `type` | `string` |

#### Inherited from

Omit.source

#### Defined in

[resources/lib/types/streams.ts:24](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/types/streams.ts#L24)

___

### toArray

• **toArray**: `any`

#### Defined in

[resources/lib/Streams/Stream.ts:84](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Streams/Stream.ts#L84)

___

### toJson

• **toJson**: `any`

#### Defined in

[resources/lib/Streams/Stream.ts:85](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Streams/Stream.ts#L85)

___

### updated\_at

• **updated\_at**: `string`

#### Inherited from

Omit.updated\_at

#### Defined in

[resources/lib/types/streams.ts:22](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/types/streams.ts#L22)

## Accessors

### repository

• `get` **repository**(): [`Repository`](Repository.md)<`ID`\>

Return the entries repository.

#### Returns

[`Repository`](Repository.md)<`ID`\>

Repository

#### Defined in

[resources/lib/Streams/Stream.ts:56](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Streams/Stream.ts#L56)

## Methods

### entries

▸ **entries**(): [`Criteria`](Criteria.md)<`ID`\>

Return the entries criteria.

#### Returns

[`Criteria`](Criteria.md)<`ID`\>

Criteria

#### Defined in

[resources/lib/Streams/Stream.ts:70](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Streams/Stream.ts#L70)
