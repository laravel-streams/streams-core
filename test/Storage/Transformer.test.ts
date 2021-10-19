import { suite, test } from '@testdeck/mocha';
import { TestCase } from '../TestCase';
import { Criteria, Stream } from '@/Streams';
import { mock } from 'sinon';
import f from 'faker';
import { Transformer } from '@';
import { getBigDataObject } from '../_support/utils';
import { expect } from 'chai';


@suite
class TransformerTest extends TestCase{

    @test 'encode/decode big object'(){
        const obj = require('../_support/package-lock-data.json');
        const encoded = Transformer.encode(obj);
        encoded.should.be.a('string')
        const decoded = Transformer.decode(encoded);
        expect(decoded).deep.eq(obj)
    }

    @test 'encode/decode small object'(){
        const obj = require('../_support/data.json');
        const encoded = Transformer.encode(obj);
        encoded.should.be.a('string')
        const decoded = Transformer.decode(encoded);
        expect(decoded).deep.eq(obj)
    }
    @test 'encode/decode string'(){
        const value = 'hello';
        const encoded = Transformer.encode(value);
        encoded.should.be.a('string')
        const decoded = Transformer.decode(encoded);
        expect(decoded).eq(value)
    }
    @test 'encode/decode number'(){
        const value = 23424234.4334;
        const encoded = Transformer.encode(value);
        encoded.should.be.a('string')
        const decoded = Transformer.decode(encoded);
        decoded.should.be.a('number')
        decoded.should.be.eq(value)
    }
    @test 'encode/decode RegExp'(){
        const value = /^(.*?)h$/;
        const encoded = Transformer.encode(value);
        encoded.should.be.a('string')
        const decoded = Transformer.decode(encoded);
        decoded.should.be.instanceOf(RegExp)
    }
    @test 'encode/decode Date'(){
        const value = new Date(Date.now());
        const encoded = Transformer.encode(value);
        encoded.should.be.a('string')
        const decoded = Transformer.decode(encoded);
        decoded.should.be.instanceOf(Date);
    }


    @test 'encode/compress/decode/decompress big object'(){
        const obj = require('../_support/package-lock-data.json');
        const encoded = Transformer.encode(obj);
        const compressed = Transformer.compress(encoded)
        encoded.should.be.a('string')
        const decoded = Transformer.decode(Transformer.decompress(compressed));
        expect(decoded).deep.eq(obj)
    }

    @test 'encode/compress/decode/decompress small object'(){
        const obj = require('../_support/data.json');
        const encoded = Transformer.encode(obj);
        const compressed = Transformer.compress(encoded)
        encoded.should.be.a('string')
        const decoded = Transformer.decode(Transformer.decompress(compressed));
        expect(decoded).deep.eq(obj)
    }
    @test 'encode/compress/decode/decompress string'(){
        const value = 'hello';
        const encoded = Transformer.encode(value);
        const compressed = Transformer.compress(encoded)
        encoded.should.be.a('string')
        const decompressed=Transformer.decompress(compressed);
        const decoded = Transformer.decode(decompressed);
        expect(decoded).eq(value)
    }
    @test 'encode/compress/decode/decompress number'(){
        const value = 23424234.4334;
        const encoded = Transformer.encode(value);
        const compressed = Transformer.compress(encoded)
        encoded.should.be.a('string')
        const decoded = Transformer.decode(Transformer.decompress(compressed));
        decoded.should.be.a('number')
        decoded.should.be.eq(value)
    }
    @test 'encode/compress/decode/decompress RegExp'(){
        const value = /^(.*?)h$/;
        const encoded = Transformer.encode(value);
        const compressed = Transformer.compress(encoded)
        encoded.should.be.a('string')
        const decoded = Transformer.decode(Transformer.decompress(compressed));
        decoded.should.be.instanceOf(RegExp)
    }
    @test 'encode/compress/decode/decompress Date'(){
        const value = new Date(Date.now());
        const encoded = Transformer.encode(value);
        const compressed = Transformer.compress(encoded)
        encoded.should.be.a('string')
        const decoded = Transformer.decode(Transformer.decompress(compressed));
        decoded.should.be.instanceOf(Date);
        decoded.getTime().should.eq(value.getTime())

    }
}
