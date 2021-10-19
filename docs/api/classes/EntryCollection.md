[Streams Platform Client Api - v1.0.2](../README.md) / [Exports](../modules.md) / EntryCollection

# Class: EntryCollection<T\>

## Type parameters

| Name | Type |
| :------ | :------ |
| `T` | `any` |

## Hierarchy

- [`Collection`](Collection.md)<[`IEntry`](../modules.md#ientry)<`T`\>\>

  ↳ **`EntryCollection`**

## Table of contents

### Constructors

- [constructor](EntryCollection.md#constructor)

### Properties

- [length](EntryCollection.md#length)
- [links](EntryCollection.md#links)
- [meta](EntryCollection.md#meta)
- [[species]](EntryCollection.md#[species])

### Methods

- [[iterator]](EntryCollection.md#[iterator])
- [[unscopables]](EntryCollection.md#[unscopables])
- [at](EntryCollection.md#at)
- [concat](EntryCollection.md#concat)
- [copyWithin](EntryCollection.md#copywithin)
- [entries](EntryCollection.md#entries)
- [every](EntryCollection.md#every)
- [fill](EntryCollection.md#fill)
- [filter](EntryCollection.md#filter)
- [find](EntryCollection.md#find)
- [findIndex](EntryCollection.md#findindex)
- [flat](EntryCollection.md#flat)
- [flatMap](EntryCollection.md#flatmap)
- [forEach](EntryCollection.md#foreach)
- [includes](EntryCollection.md#includes)
- [indexOf](EntryCollection.md#indexof)
- [join](EntryCollection.md#join)
- [keys](EntryCollection.md#keys)
- [lastIndexOf](EntryCollection.md#lastindexof)
- [map](EntryCollection.md#map)
- [pop](EntryCollection.md#pop)
- [push](EntryCollection.md#push)
- [reduce](EntryCollection.md#reduce)
- [reduceRight](EntryCollection.md#reduceright)
- [reverse](EntryCollection.md#reverse)
- [shift](EntryCollection.md#shift)
- [slice](EntryCollection.md#slice)
- [some](EntryCollection.md#some)
- [sort](EntryCollection.md#sort)
- [splice](EntryCollection.md#splice)
- [toLocaleString](EntryCollection.md#tolocalestring)
- [toString](EntryCollection.md#tostring)
- [unshift](EntryCollection.md#unshift)
- [values](EntryCollection.md#values)
- [from](EntryCollection.md#from)
- [fromResponse](EntryCollection.md#fromresponse)
- [isArray](EntryCollection.md#isarray)
- [of](EntryCollection.md#of)

## Constructors

### constructor

• **new EntryCollection**<`T`\>(`entries`, `meta?`, `links?`)

Create a new collection instance.

#### Type parameters

| Name | Type |
| :------ | :------ |
| `T` | `any` |

#### Parameters

| Name | Type |
| :------ | :------ |
| `entries` | [`IEntry`](../modules.md#ientry)<`T`, `string`\>[] |
| `meta?` | [`IEntriesMeta`](../interfaces/IEntriesMeta.md) |
| `links?` | [`IEntriesLinks`](../modules.md#ientrieslinks) |

#### Overrides

[Collection](Collection.md).[constructor](Collection.md#constructor)

#### Defined in

[resources/lib/Streams/EntryCollection.ts:22](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Streams/EntryCollection.ts#L22)

## Properties

### length

• **length**: `number`

Gets or sets the length of the array. This is a number one higher than the highest index in the array.

#### Inherited from

[Collection](Collection.md).[length](Collection.md#length)

#### Defined in

node_modules/typescript/lib/lib.es5.d.ts:1224

___

### links

• `Optional` `Readonly` **links**: [`IEntriesLinks`](../modules.md#ientrieslinks)

___

### meta

• `Optional` `Readonly` **meta**: [`IEntriesMeta`](../interfaces/IEntriesMeta.md)

___

### [species]

▪ `Static` `Readonly` **[species]**: `ArrayConstructor`

#### Inherited from

[Collection](Collection.md).[[species]](Collection.md#[species])

#### Defined in

node_modules/typescript/lib/lib.es2015.symbol.wellknown.d.ts:314

## Methods

### [iterator]

▸ **[iterator]**(): `IterableIterator`<[`IEntry`](../modules.md#ientry)<`T`, `string`\>\>

Iterator

#### Returns

`IterableIterator`<[`IEntry`](../modules.md#ientry)<`T`, `string`\>\>

#### Inherited from

[Collection](Collection.md).[[iterator]](Collection.md#[iterator])

#### Defined in

node_modules/typescript/lib/lib.es2015.iterable.d.ts:60

___

### [unscopables]

▸ **[unscopables]**(): `Object`

Returns an object whose properties have the value 'true'
when they will be absent when used in a 'with' statement.

#### Returns

`Object`

| Name | Type |
| :------ | :------ |
| `copyWithin` | `boolean` |
| `entries` | `boolean` |
| `fill` | `boolean` |
| `find` | `boolean` |
| `findIndex` | `boolean` |
| `keys` | `boolean` |
| `values` | `boolean` |

#### Inherited from

[Collection](Collection.md).[[unscopables]](Collection.md#[unscopables])

#### Defined in

node_modules/typescript/lib/lib.es2015.symbol.wellknown.d.ts:99

___

### at

▸ **at**(`index`): [`IEntry`](../modules.md#ientry)<`T`, `string`\>

Takes an integer value and returns the item at that index,
allowing for positive and negative integers.
Negative integers count back from the last item in the array.

#### Parameters

| Name | Type |
| :------ | :------ |
| `index` | `number` |

#### Returns

[`IEntry`](../modules.md#ientry)<`T`, `string`\>

#### Inherited from

[Collection](Collection.md).[at](Collection.md#at)

#### Defined in

node_modules/@types/node/globals.d.ts:86

___

### concat

▸ **concat**(...`items`): [`IEntry`](../modules.md#ientry)<`T`, `string`\>[]

Combines two or more arrays.
This method returns a new array without modifying any existing arrays.

#### Parameters

| Name | Type | Description |
| :------ | :------ | :------ |
| `...items` | `ConcatArray`<[`IEntry`](../modules.md#ientry)<`T`, `string`\>\>[] | Additional arrays and/or items to add to the end of the array. |

#### Returns

[`IEntry`](../modules.md#ientry)<`T`, `string`\>[]

#### Inherited from

[Collection](Collection.md).[concat](Collection.md#concat)

#### Defined in

node_modules/typescript/lib/lib.es5.d.ts:1248

▸ **concat**(...`items`): [`IEntry`](../modules.md#ientry)<`T`, `string`\>[]

Combines two or more arrays.
This method returns a new array without modifying any existing arrays.

#### Parameters

| Name | Type | Description |
| :------ | :------ | :------ |
| `...items` | ([`IEntry`](../modules.md#ientry)<`T`, `string`\> \| `ConcatArray`<[`IEntry`](../modules.md#ientry)<`T`, `string`\>\>)[] | Additional arrays and/or items to add to the end of the array. |

#### Returns

[`IEntry`](../modules.md#ientry)<`T`, `string`\>[]

#### Inherited from

[Collection](Collection.md).[concat](Collection.md#concat)

#### Defined in

node_modules/typescript/lib/lib.es5.d.ts:1254

___

### copyWithin

▸ **copyWithin**(`target`, `start`, `end?`): [`EntryCollection`](EntryCollection.md)<`T`\>

Returns the this object after copying a section of the array identified by start and end
to the same array starting at position target

#### Parameters

| Name | Type | Description |
| :------ | :------ | :------ |
| `target` | `number` | If target is negative, it is treated as length+target where length is the length of the array. |
| `start` | `number` | If start is negative, it is treated as length+start. If end is negative, it is treated as length+end. |
| `end?` | `number` | If not specified, length of the this object is used as its default value. |

#### Returns

[`EntryCollection`](EntryCollection.md)<`T`\>

#### Inherited from

[Collection](Collection.md).[copyWithin](Collection.md#copywithin)

#### Defined in

node_modules/typescript/lib/lib.es2015.core.d.ts:64

___

### entries

▸ **entries**(): `IterableIterator`<[`number`, [`IEntry`](../modules.md#ientry)<`T`, `string`\>]\>

Returns an iterable of key, value pairs for every entry in the array

#### Returns

`IterableIterator`<[`number`, [`IEntry`](../modules.md#ientry)<`T`, `string`\>]\>

#### Inherited from

[Collection](Collection.md).[entries](Collection.md#entries)

#### Defined in

node_modules/typescript/lib/lib.es2015.iterable.d.ts:65

___

### every

▸ **every**<`S`\>(`predicate`, `thisArg?`): this is S[]

Determines whether all the members of an array satisfy the specified test.

#### Type parameters

| Name | Type |
| :------ | :------ |
| `S` | extends [`Entry`](Entry.md)<`string`, `S`\> |

#### Parameters

| Name | Type | Description |
| :------ | :------ | :------ |
| `predicate` | (`value`: [`IEntry`](../modules.md#ientry)<`T`, `string`\>, `index`: `number`, `array`: [`IEntry`](../modules.md#ientry)<`T`, `string`\>[]) => value is S | A function that accepts up to three arguments. The every method calls the predicate function for each element in the array until the predicate returns a value which is coercible to the Boolean value false, or until the end of the array. |
| `thisArg?` | `any` | An object to which the this keyword can refer in the predicate function. If thisArg is omitted, undefined is used as the this value. |

#### Returns

this is S[]

#### Inherited from

[Collection](Collection.md).[every](Collection.md#every)

#### Defined in

node_modules/typescript/lib/lib.es5.d.ts:1331

▸ **every**(`predicate`, `thisArg?`): `boolean`

Determines whether all the members of an array satisfy the specified test.

#### Parameters

| Name | Type | Description |
| :------ | :------ | :------ |
| `predicate` | (`value`: [`IEntry`](../modules.md#ientry)<`T`, `string`\>, `index`: `number`, `array`: [`IEntry`](../modules.md#ientry)<`T`, `string`\>[]) => `unknown` | A function that accepts up to three arguments. The every method calls the predicate function for each element in the array until the predicate returns a value which is coercible to the Boolean value false, or until the end of the array. |
| `thisArg?` | `any` | An object to which the this keyword can refer in the predicate function. If thisArg is omitted, undefined is used as the this value. |

#### Returns

`boolean`

#### Inherited from

[Collection](Collection.md).[every](Collection.md#every)

#### Defined in

node_modules/typescript/lib/lib.es5.d.ts:1340

___

### fill

▸ **fill**(`value`, `start?`, `end?`): [`EntryCollection`](EntryCollection.md)<`T`\>

Changes all array elements from `start` to `end` index to a static `value` and returns the modified array

#### Parameters

| Name | Type | Description |
| :------ | :------ | :------ |
| `value` | [`IEntry`](../modules.md#ientry)<`T`, `string`\> | value to fill array section with |
| `start?` | `number` | index to start filling the array at. If start is negative, it is treated as length+start where length is the length of the array. |
| `end?` | `number` | index to stop filling the array at. If end is negative, it is treated as length+end. |

#### Returns

[`EntryCollection`](EntryCollection.md)<`T`\>

#### Inherited from

[Collection](Collection.md).[fill](Collection.md#fill)

#### Defined in

node_modules/typescript/lib/lib.es2015.core.d.ts:53

___

### filter

▸ **filter**<`S`\>(`predicate`, `thisArg?`): `S`[]

Returns the elements of an array that meet the condition specified in a callback function.

#### Type parameters

| Name | Type |
| :------ | :------ |
| `S` | extends [`Entry`](Entry.md)<`string`, `S`\> |

#### Parameters

| Name | Type | Description |
| :------ | :------ | :------ |
| `predicate` | (`value`: [`IEntry`](../modules.md#ientry)<`T`, `string`\>, `index`: `number`, `array`: [`IEntry`](../modules.md#ientry)<`T`, `string`\>[]) => value is S | A function that accepts up to three arguments. The filter method calls the predicate function one time for each element in the array. |
| `thisArg?` | `any` | An object to which the this keyword can refer in the predicate function. If thisArg is omitted, undefined is used as the this value. |

#### Returns

`S`[]

#### Inherited from

[Collection](Collection.md).[filter](Collection.md#filter)

#### Defined in

node_modules/typescript/lib/lib.es5.d.ts:1367

▸ **filter**(`predicate`, `thisArg?`): [`IEntry`](../modules.md#ientry)<`T`, `string`\>[]

Returns the elements of an array that meet the condition specified in a callback function.

#### Parameters

| Name | Type | Description |
| :------ | :------ | :------ |
| `predicate` | (`value`: [`IEntry`](../modules.md#ientry)<`T`, `string`\>, `index`: `number`, `array`: [`IEntry`](../modules.md#ientry)<`T`, `string`\>[]) => `unknown` | A function that accepts up to three arguments. The filter method calls the predicate function one time for each element in the array. |
| `thisArg?` | `any` | An object to which the this keyword can refer in the predicate function. If thisArg is omitted, undefined is used as the this value. |

#### Returns

[`IEntry`](../modules.md#ientry)<`T`, `string`\>[]

#### Inherited from

[Collection](Collection.md).[filter](Collection.md#filter)

#### Defined in

node_modules/typescript/lib/lib.es5.d.ts:1373

___

### find

▸ **find**<`S`\>(`predicate`, `thisArg?`): `S`

Returns the value of the first element in the array where predicate is true, and undefined
otherwise.

#### Type parameters

| Name | Type |
| :------ | :------ |
| `S` | extends [`Entry`](Entry.md)<`string`, `S`\> |

#### Parameters

| Name | Type | Description |
| :------ | :------ | :------ |
| `predicate` | (`value`: [`IEntry`](../modules.md#ientry)<`T`, `string`\>, `index`: `number`, `obj`: [`IEntry`](../modules.md#ientry)<`T`, `string`\>[]) => value is S | find calls predicate once for each element of the array, in ascending order, until it finds one where predicate returns true. If such an element is found, find immediately returns that element value. Otherwise, find returns undefined. |
| `thisArg?` | `any` | If provided, it will be used as the this value for each invocation of predicate. If it is not provided, undefined is used instead. |

#### Returns

`S`

#### Inherited from

[Collection](Collection.md).[find](Collection.md#find)

#### Defined in

node_modules/typescript/lib/lib.es2015.core.d.ts:31

▸ **find**(`predicate`, `thisArg?`): [`IEntry`](../modules.md#ientry)<`T`, `string`\>

#### Parameters

| Name | Type |
| :------ | :------ |
| `predicate` | (`value`: [`IEntry`](../modules.md#ientry)<`T`, `string`\>, `index`: `number`, `obj`: [`IEntry`](../modules.md#ientry)<`T`, `string`\>[]) => `unknown` |
| `thisArg?` | `any` |

#### Returns

[`IEntry`](../modules.md#ientry)<`T`, `string`\>

#### Inherited from

[Collection](Collection.md).[find](Collection.md#find)

#### Defined in

node_modules/typescript/lib/lib.es2015.core.d.ts:32

___

### findIndex

▸ **findIndex**(`predicate`, `thisArg?`): `number`

Returns the index of the first element in the array where predicate is true, and -1
otherwise.

#### Parameters

| Name | Type | Description |
| :------ | :------ | :------ |
| `predicate` | (`value`: [`IEntry`](../modules.md#ientry)<`T`, `string`\>, `index`: `number`, `obj`: [`IEntry`](../modules.md#ientry)<`T`, `string`\>[]) => `unknown` | find calls predicate once for each element of the array, in ascending order, until it finds one where predicate returns true. If such an element is found, findIndex immediately returns that element index. Otherwise, findIndex returns -1. |
| `thisArg?` | `any` | If provided, it will be used as the this value for each invocation of predicate. If it is not provided, undefined is used instead. |

#### Returns

`number`

#### Inherited from

[Collection](Collection.md).[findIndex](Collection.md#findindex)

#### Defined in

node_modules/typescript/lib/lib.es2015.core.d.ts:43

___

### flat

▸ **flat**<`A`, `D`\>(`depth?`): `FlatArray`<`A`, `D`\>[]

Returns a new array with all sub-array elements concatenated into it recursively up to the
specified depth.

#### Type parameters

| Name | Type |
| :------ | :------ |
| `A` | `A` |
| `D` | extends `number```1`` |

#### Parameters

| Name | Type | Description |
| :------ | :------ | :------ |
| `depth?` | `D` | The maximum recursion depth |

#### Returns

`FlatArray`<`A`, `D`\>[]

#### Inherited from

[Collection](Collection.md).[flat](Collection.md#flat)

#### Defined in

node_modules/typescript/lib/lib.es2019.array.d.ts:81

___

### flatMap

▸ **flatMap**<`U`, `This`\>(`callback`, `thisArg?`): `U`[]

Calls a defined callback function on each element of an array. Then, flattens the result into
a new array.
This is identical to a map followed by flat with depth 1.

#### Type parameters

| Name | Type |
| :------ | :------ |
| `U` | `U` |
| `This` | `undefined` |

#### Parameters

| Name | Type | Description |
| :------ | :------ | :------ |
| `callback` | (`value`: [`IEntry`](../modules.md#ientry)<`T`, `string`\>, `index`: `number`, `array`: [`IEntry`](../modules.md#ientry)<`T`, `string`\>[]) => `U` \| readonly `U`[] | A function that accepts up to three arguments. The flatMap method calls the callback function one time for each element in the array. |
| `thisArg?` | `This` | An object to which the this keyword can refer in the callback function. If thisArg is omitted, undefined is used as the this value. |

#### Returns

`U`[]

#### Inherited from

[Collection](Collection.md).[flatMap](Collection.md#flatmap)

#### Defined in

node_modules/typescript/lib/lib.es2019.array.d.ts:70

___

### forEach

▸ **forEach**(`callbackfn`, `thisArg?`): `void`

Performs the specified action for each element in an array.

#### Parameters

| Name | Type | Description |
| :------ | :------ | :------ |
| `callbackfn` | (`value`: [`IEntry`](../modules.md#ientry)<`T`, `string`\>, `index`: `number`, `array`: [`IEntry`](../modules.md#ientry)<`T`, `string`\>[]) => `void` | A function that accepts up to three arguments. forEach calls the callbackfn function one time for each element in the array. |
| `thisArg?` | `any` | An object to which the this keyword can refer in the callbackfn function. If thisArg is omitted, undefined is used as the this value. |

#### Returns

`void`

#### Inherited from

[Collection](Collection.md).[forEach](Collection.md#foreach)

#### Defined in

node_modules/typescript/lib/lib.es5.d.ts:1355

___

### includes

▸ **includes**(`searchElement`, `fromIndex?`): `boolean`

Determines whether an array includes a certain element, returning true or false as appropriate.

#### Parameters

| Name | Type | Description |
| :------ | :------ | :------ |
| `searchElement` | [`IEntry`](../modules.md#ientry)<`T`, `string`\> | The element to search for. |
| `fromIndex?` | `number` | The position in this array at which to begin searching for searchElement. |

#### Returns

`boolean`

#### Inherited from

[Collection](Collection.md).[includes](Collection.md#includes)

#### Defined in

node_modules/typescript/lib/lib.es2016.array.include.d.ts:27

___

### indexOf

▸ **indexOf**(`searchElement`, `fromIndex?`): `number`

Returns the index of the first occurrence of a value in an array, or -1 if it is not present.

#### Parameters

| Name | Type | Description |
| :------ | :------ | :------ |
| `searchElement` | [`IEntry`](../modules.md#ientry)<`T`, `string`\> | The value to locate in the array. |
| `fromIndex?` | `number` | The array index at which to begin the search. If fromIndex is omitted, the search starts at index 0. |

#### Returns

`number`

#### Inherited from

[Collection](Collection.md).[indexOf](Collection.md#indexof)

#### Defined in

node_modules/typescript/lib/lib.es5.d.ts:1316

___

### join

▸ **join**(`separator?`): `string`

Adds all the elements of an array into a string, separated by the specified separator string.

#### Parameters

| Name | Type | Description |
| :------ | :------ | :------ |
| `separator?` | `string` | A string used to separate one element of the array from the next in the resulting string. If omitted, the array elements are separated with a comma. |

#### Returns

`string`

#### Inherited from

[Collection](Collection.md).[join](Collection.md#join)

#### Defined in

node_modules/typescript/lib/lib.es5.d.ts:1259

___

### keys

▸ **keys**(): `IterableIterator`<`number`\>

Returns an iterable of keys in the array

#### Returns

`IterableIterator`<`number`\>

#### Inherited from

[Collection](Collection.md).[keys](Collection.md#keys)

#### Defined in

node_modules/typescript/lib/lib.es2015.iterable.d.ts:70

___

### lastIndexOf

▸ **lastIndexOf**(`searchElement`, `fromIndex?`): `number`

Returns the index of the last occurrence of a specified value in an array, or -1 if it is not present.

#### Parameters

| Name | Type | Description |
| :------ | :------ | :------ |
| `searchElement` | [`IEntry`](../modules.md#ientry)<`T`, `string`\> | The value to locate in the array. |
| `fromIndex?` | `number` | The array index at which to begin searching backward. If fromIndex is omitted, the search starts at the last index in the array. |

#### Returns

`number`

#### Inherited from

[Collection](Collection.md).[lastIndexOf](Collection.md#lastindexof)

#### Defined in

node_modules/typescript/lib/lib.es5.d.ts:1322

___

### map

▸ **map**<`U`\>(`callbackfn`, `thisArg?`): `U`[]

Calls a defined callback function on each element of an array, and returns an array that contains the results.

#### Type parameters

| Name |
| :------ |
| `U` |

#### Parameters

| Name | Type | Description |
| :------ | :------ | :------ |
| `callbackfn` | (`value`: [`IEntry`](../modules.md#ientry)<`T`, `string`\>, `index`: `number`, `array`: [`IEntry`](../modules.md#ientry)<`T`, `string`\>[]) => `U` | A function that accepts up to three arguments. The map method calls the callbackfn function one time for each element in the array. |
| `thisArg?` | `any` | An object to which the this keyword can refer in the callbackfn function. If thisArg is omitted, undefined is used as the this value. |

#### Returns

`U`[]

#### Inherited from

[Collection](Collection.md).[map](Collection.md#map)

#### Defined in

node_modules/typescript/lib/lib.es5.d.ts:1361

___

### pop

▸ **pop**(): [`IEntry`](../modules.md#ientry)<`T`, `string`\>

Removes the last element from an array and returns it.
If the array is empty, undefined is returned and the array is not modified.

#### Returns

[`IEntry`](../modules.md#ientry)<`T`, `string`\>

#### Inherited from

[Collection](Collection.md).[pop](Collection.md#pop)

#### Defined in

node_modules/typescript/lib/lib.es5.d.ts:1237

___

### push

▸ **push**(...`items`): `number`

Appends new elements to the end of an array, and returns the new length of the array.

#### Parameters

| Name | Type | Description |
| :------ | :------ | :------ |
| `...items` | [`IEntry`](../modules.md#ientry)<`T`, `string`\>[] | New elements to add to the array. |

#### Returns

`number`

#### Inherited from

[Collection](Collection.md).[push](Collection.md#push)

#### Defined in

node_modules/typescript/lib/lib.es5.d.ts:1242

___

### reduce

▸ **reduce**(`callbackfn`): [`IEntry`](../modules.md#ientry)<`T`, `string`\>

Calls the specified callback function for all the elements in an array. The return value of the callback function is the accumulated result, and is provided as an argument in the next call to the callback function.

#### Parameters

| Name | Type | Description |
| :------ | :------ | :------ |
| `callbackfn` | (`previousValue`: [`IEntry`](../modules.md#ientry)<`T`, `string`\>, `currentValue`: [`IEntry`](../modules.md#ientry)<`T`, `string`\>, `currentIndex`: `number`, `array`: [`IEntry`](../modules.md#ientry)<`T`, `string`\>[]) => [`IEntry`](../modules.md#ientry)<`T`, `string`\> | A function that accepts up to four arguments. The reduce method calls the callbackfn function one time for each element in the array. |

#### Returns

[`IEntry`](../modules.md#ientry)<`T`, `string`\>

#### Inherited from

[Collection](Collection.md).[reduce](Collection.md#reduce)

#### Defined in

node_modules/typescript/lib/lib.es5.d.ts:1379

▸ **reduce**(`callbackfn`, `initialValue`): [`IEntry`](../modules.md#ientry)<`T`, `string`\>

#### Parameters

| Name | Type |
| :------ | :------ |
| `callbackfn` | (`previousValue`: [`IEntry`](../modules.md#ientry)<`T`, `string`\>, `currentValue`: [`IEntry`](../modules.md#ientry)<`T`, `string`\>, `currentIndex`: `number`, `array`: [`IEntry`](../modules.md#ientry)<`T`, `string`\>[]) => [`IEntry`](../modules.md#ientry)<`T`, `string`\> |
| `initialValue` | [`IEntry`](../modules.md#ientry)<`T`, `string`\> |

#### Returns

[`IEntry`](../modules.md#ientry)<`T`, `string`\>

#### Inherited from

[Collection](Collection.md).[reduce](Collection.md#reduce)

#### Defined in

node_modules/typescript/lib/lib.es5.d.ts:1380

▸ **reduce**<`U`\>(`callbackfn`, `initialValue`): `U`

Calls the specified callback function for all the elements in an array. The return value of the callback function is the accumulated result, and is provided as an argument in the next call to the callback function.

#### Type parameters

| Name |
| :------ |
| `U` |

#### Parameters

| Name | Type | Description |
| :------ | :------ | :------ |
| `callbackfn` | (`previousValue`: `U`, `currentValue`: [`IEntry`](../modules.md#ientry)<`T`, `string`\>, `currentIndex`: `number`, `array`: [`IEntry`](../modules.md#ientry)<`T`, `string`\>[]) => `U` | A function that accepts up to four arguments. The reduce method calls the callbackfn function one time for each element in the array. |
| `initialValue` | `U` | If initialValue is specified, it is used as the initial value to start the accumulation. The first call to the callbackfn function provides this value as an argument instead of an array value. |

#### Returns

`U`

#### Inherited from

[Collection](Collection.md).[reduce](Collection.md#reduce)

#### Defined in

node_modules/typescript/lib/lib.es5.d.ts:1386

___

### reduceRight

▸ **reduceRight**(`callbackfn`): [`IEntry`](../modules.md#ientry)<`T`, `string`\>

Calls the specified callback function for all the elements in an array, in descending order. The return value of the callback function is the accumulated result, and is provided as an argument in the next call to the callback function.

#### Parameters

| Name | Type | Description |
| :------ | :------ | :------ |
| `callbackfn` | (`previousValue`: [`IEntry`](../modules.md#ientry)<`T`, `string`\>, `currentValue`: [`IEntry`](../modules.md#ientry)<`T`, `string`\>, `currentIndex`: `number`, `array`: [`IEntry`](../modules.md#ientry)<`T`, `string`\>[]) => [`IEntry`](../modules.md#ientry)<`T`, `string`\> | A function that accepts up to four arguments. The reduceRight method calls the callbackfn function one time for each element in the array. |

#### Returns

[`IEntry`](../modules.md#ientry)<`T`, `string`\>

#### Inherited from

[Collection](Collection.md).[reduceRight](Collection.md#reduceright)

#### Defined in

node_modules/typescript/lib/lib.es5.d.ts:1392

▸ **reduceRight**(`callbackfn`, `initialValue`): [`IEntry`](../modules.md#ientry)<`T`, `string`\>

#### Parameters

| Name | Type |
| :------ | :------ |
| `callbackfn` | (`previousValue`: [`IEntry`](../modules.md#ientry)<`T`, `string`\>, `currentValue`: [`IEntry`](../modules.md#ientry)<`T`, `string`\>, `currentIndex`: `number`, `array`: [`IEntry`](../modules.md#ientry)<`T`, `string`\>[]) => [`IEntry`](../modules.md#ientry)<`T`, `string`\> |
| `initialValue` | [`IEntry`](../modules.md#ientry)<`T`, `string`\> |

#### Returns

[`IEntry`](../modules.md#ientry)<`T`, `string`\>

#### Inherited from

[Collection](Collection.md).[reduceRight](Collection.md#reduceright)

#### Defined in

node_modules/typescript/lib/lib.es5.d.ts:1393

▸ **reduceRight**<`U`\>(`callbackfn`, `initialValue`): `U`

Calls the specified callback function for all the elements in an array, in descending order. The return value of the callback function is the accumulated result, and is provided as an argument in the next call to the callback function.

#### Type parameters

| Name |
| :------ |
| `U` |

#### Parameters

| Name | Type | Description |
| :------ | :------ | :------ |
| `callbackfn` | (`previousValue`: `U`, `currentValue`: [`IEntry`](../modules.md#ientry)<`T`, `string`\>, `currentIndex`: `number`, `array`: [`IEntry`](../modules.md#ientry)<`T`, `string`\>[]) => `U` | A function that accepts up to four arguments. The reduceRight method calls the callbackfn function one time for each element in the array. |
| `initialValue` | `U` | If initialValue is specified, it is used as the initial value to start the accumulation. The first call to the callbackfn function provides this value as an argument instead of an array value. |

#### Returns

`U`

#### Inherited from

[Collection](Collection.md).[reduceRight](Collection.md#reduceright)

#### Defined in

node_modules/typescript/lib/lib.es5.d.ts:1399

___

### reverse

▸ **reverse**(): [`IEntry`](../modules.md#ientry)<`T`, `string`\>[]

Reverses the elements in an array in place.
This method mutates the array and returns a reference to the same array.

#### Returns

[`IEntry`](../modules.md#ientry)<`T`, `string`\>[]

#### Inherited from

[Collection](Collection.md).[reverse](Collection.md#reverse)

#### Defined in

node_modules/typescript/lib/lib.es5.d.ts:1264

___

### shift

▸ **shift**(): [`IEntry`](../modules.md#ientry)<`T`, `string`\>

Removes the first element from an array and returns it.
If the array is empty, undefined is returned and the array is not modified.

#### Returns

[`IEntry`](../modules.md#ientry)<`T`, `string`\>

#### Inherited from

[Collection](Collection.md).[shift](Collection.md#shift)

#### Defined in

node_modules/typescript/lib/lib.es5.d.ts:1269

___

### slice

▸ **slice**(`start?`, `end?`): [`IEntry`](../modules.md#ientry)<`T`, `string`\>[]

Returns a copy of a section of an array.
For both start and end, a negative index can be used to indicate an offset from the end of the array.
For example, -2 refers to the second to last element of the array.

#### Parameters

| Name | Type | Description |
| :------ | :------ | :------ |
| `start?` | `number` | The beginning index of the specified portion of the array. If start is undefined, then the slice begins at index 0. |
| `end?` | `number` | The end index of the specified portion of the array. This is exclusive of the element at the index 'end'. If end is undefined, then the slice extends to the end of the array. |

#### Returns

[`IEntry`](../modules.md#ientry)<`T`, `string`\>[]

#### Inherited from

[Collection](Collection.md).[slice](Collection.md#slice)

#### Defined in

node_modules/typescript/lib/lib.es5.d.ts:1279

___

### some

▸ **some**(`predicate`, `thisArg?`): `boolean`

Determines whether the specified callback function returns true for any element of an array.

#### Parameters

| Name | Type | Description |
| :------ | :------ | :------ |
| `predicate` | (`value`: [`IEntry`](../modules.md#ientry)<`T`, `string`\>, `index`: `number`, `array`: [`IEntry`](../modules.md#ientry)<`T`, `string`\>[]) => `unknown` | A function that accepts up to three arguments. The some method calls the predicate function for each element in the array until the predicate returns a value which is coercible to the Boolean value true, or until the end of the array. |
| `thisArg?` | `any` | An object to which the this keyword can refer in the predicate function. If thisArg is omitted, undefined is used as the this value. |

#### Returns

`boolean`

#### Inherited from

[Collection](Collection.md).[some](Collection.md#some)

#### Defined in

node_modules/typescript/lib/lib.es5.d.ts:1349

___

### sort

▸ **sort**(`compareFn?`): [`EntryCollection`](EntryCollection.md)<`T`\>

Sorts an array in place.
This method mutates the array and returns a reference to the same array.

#### Parameters

| Name | Type | Description |
| :------ | :------ | :------ |
| `compareFn?` | (`a`: [`IEntry`](../modules.md#ientry)<`T`, `string`\>, `b`: [`IEntry`](../modules.md#ientry)<`T`, `string`\>) => `number` | Function used to determine the order of the elements. It is expected to return a negative value if first argument is less than second argument, zero if they're equal and a positive value otherwise. If omitted, the elements are sorted in ascending, ASCII character order. ```ts [11,2,22,1].sort((a, b) => a - b) ``` |

#### Returns

[`EntryCollection`](EntryCollection.md)<`T`\>

#### Inherited from

[Collection](Collection.md).[sort](Collection.md#sort)

#### Defined in

node_modules/typescript/lib/lib.es5.d.ts:1290

___

### splice

▸ **splice**(`start`, `deleteCount?`): [`IEntry`](../modules.md#ientry)<`T`, `string`\>[]

Removes elements from an array and, if necessary, inserts new elements in their place, returning the deleted elements.

#### Parameters

| Name | Type | Description |
| :------ | :------ | :------ |
| `start` | `number` | The zero-based location in the array from which to start removing elements. |
| `deleteCount?` | `number` | The number of elements to remove. |

#### Returns

[`IEntry`](../modules.md#ientry)<`T`, `string`\>[]

An array containing the elements that were deleted.

#### Inherited from

[Collection](Collection.md).[splice](Collection.md#splice)

#### Defined in

node_modules/typescript/lib/lib.es5.d.ts:1297

▸ **splice**(`start`, `deleteCount`, ...`items`): [`IEntry`](../modules.md#ientry)<`T`, `string`\>[]

Removes elements from an array and, if necessary, inserts new elements in their place, returning the deleted elements.

#### Parameters

| Name | Type | Description |
| :------ | :------ | :------ |
| `start` | `number` | The zero-based location in the array from which to start removing elements. |
| `deleteCount` | `number` | The number of elements to remove. |
| `...items` | [`IEntry`](../modules.md#ientry)<`T`, `string`\>[] | Elements to insert into the array in place of the deleted elements. |

#### Returns

[`IEntry`](../modules.md#ientry)<`T`, `string`\>[]

An array containing the elements that were deleted.

#### Inherited from

[Collection](Collection.md).[splice](Collection.md#splice)

#### Defined in

node_modules/typescript/lib/lib.es5.d.ts:1305

___

### toLocaleString

▸ **toLocaleString**(): `string`

Returns a string representation of an array. The elements are converted to string using their toLocaleString methods.

#### Returns

`string`

#### Inherited from

[Collection](Collection.md).[toLocaleString](Collection.md#tolocalestring)

#### Defined in

node_modules/typescript/lib/lib.es5.d.ts:1232

___

### toString

▸ **toString**(): `string`

Returns a string representation of an array.

#### Returns

`string`

#### Inherited from

[Collection](Collection.md).[toString](Collection.md#tostring)

#### Defined in

node_modules/typescript/lib/lib.es5.d.ts:1228

___

### unshift

▸ **unshift**(...`items`): `number`

Inserts new elements at the start of an array, and returns the new length of the array.

#### Parameters

| Name | Type | Description |
| :------ | :------ | :------ |
| `...items` | [`IEntry`](../modules.md#ientry)<`T`, `string`\>[] | Elements to insert at the start of the array. |

#### Returns

`number`

#### Inherited from

[Collection](Collection.md).[unshift](Collection.md#unshift)

#### Defined in

node_modules/typescript/lib/lib.es5.d.ts:1310

___

### values

▸ **values**(): `IterableIterator`<[`IEntry`](../modules.md#ientry)<`T`, `string`\>\>

Returns an iterable of values in the array

#### Returns

`IterableIterator`<[`IEntry`](../modules.md#ientry)<`T`, `string`\>\>

#### Inherited from

[Collection](Collection.md).[values](Collection.md#values)

#### Defined in

node_modules/typescript/lib/lib.es2015.iterable.d.ts:75

___

### from

▸ `Static` **from**<`T`\>(`arrayLike`): `T`[]

Creates an array from an array-like object.

#### Type parameters

| Name |
| :------ |
| `T` |

#### Parameters

| Name | Type | Description |
| :------ | :------ | :------ |
| `arrayLike` | `ArrayLike`<`T`\> | An array-like object to convert to an array. |

#### Returns

`T`[]

#### Inherited from

[Collection](Collection.md).[from](Collection.md#from)

#### Defined in

node_modules/typescript/lib/lib.es2015.core.d.ts:72

▸ `Static` **from**<`T`, `U`\>(`arrayLike`, `mapfn`, `thisArg?`): `U`[]

Creates an array from an iterable object.

#### Type parameters

| Name |
| :------ |
| `T` |
| `U` |

#### Parameters

| Name | Type | Description |
| :------ | :------ | :------ |
| `arrayLike` | `ArrayLike`<`T`\> | An array-like object to convert to an array. |
| `mapfn` | (`v`: `T`, `k`: `number`) => `U` | A mapping function to call on every element of the array. |
| `thisArg?` | `any` | Value of 'this' used to invoke the mapfn. |

#### Returns

`U`[]

#### Inherited from

[Collection](Collection.md).[from](Collection.md#from)

#### Defined in

node_modules/typescript/lib/lib.es2015.core.d.ts:80

▸ `Static` **from**<`T`\>(`iterable`): `T`[]

Creates an array from an iterable object.

#### Type parameters

| Name |
| :------ |
| `T` |

#### Parameters

| Name | Type | Description |
| :------ | :------ | :------ |
| `iterable` | `Iterable`<`T`\> \| `ArrayLike`<`T`\> | An iterable object to convert to an array. |

#### Returns

`T`[]

#### Inherited from

[Collection](Collection.md).[from](Collection.md#from)

#### Defined in

node_modules/typescript/lib/lib.es2015.iterable.d.ts:83

▸ `Static` **from**<`T`, `U`\>(`iterable`, `mapfn`, `thisArg?`): `U`[]

Creates an array from an iterable object.

#### Type parameters

| Name |
| :------ |
| `T` |
| `U` |

#### Parameters

| Name | Type | Description |
| :------ | :------ | :------ |
| `iterable` | `Iterable`<`T`\> \| `ArrayLike`<`T`\> | An iterable object to convert to an array. |
| `mapfn` | (`v`: `T`, `k`: `number`) => `U` | A mapping function to call on every element of the array. |
| `thisArg?` | `any` | Value of 'this' used to invoke the mapfn. |

#### Returns

`U`[]

#### Inherited from

[Collection](Collection.md).[from](Collection.md#from)

#### Defined in

node_modules/typescript/lib/lib.es2015.iterable.d.ts:91

___

### fromResponse

▸ `Static` **fromResponse**<`T`\>(`response`, `stream`): [`EntryCollection`](EntryCollection.md)<`T`\>

#### Type parameters

| Name |
| :------ |
| `T` |

#### Parameters

| Name | Type |
| :------ | :------ |
| `response` | [`StreamResponse`](../interfaces/Http.StreamResponse.md)<`T`[], [`IEntriesMeta`](../interfaces/IEntriesMeta.md), [`IEntriesLinks`](../modules.md#ientrieslinks)\> |
| `stream` | [`Stream`](Stream.md)<`string`\> |

#### Returns

[`EntryCollection`](EntryCollection.md)<`T`\>

#### Defined in

[resources/lib/Streams/EntryCollection.ts:26](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Streams/EntryCollection.ts#L26)

___

### isArray

▸ `Static` **isArray**(`arg`): arg is any[]

#### Parameters

| Name | Type |
| :------ | :------ |
| `arg` | `any` |

#### Returns

arg is any[]

#### Inherited from

[Collection](Collection.md).[isArray](Collection.md#isarray)

#### Defined in

node_modules/typescript/lib/lib.es5.d.ts:1411

___

### of

▸ `Static` **of**<`T`\>(...`items`): `T`[]

Returns a new array from a set of elements.

#### Type parameters

| Name |
| :------ |
| `T` |

#### Parameters

| Name | Type | Description |
| :------ | :------ | :------ |
| `...items` | `T`[] | A set of elements to include in the new array object. |

#### Returns

`T`[]

#### Inherited from

[Collection](Collection.md).[of](Collection.md#of)

#### Defined in

node_modules/typescript/lib/lib.es2015.core.d.ts:86
