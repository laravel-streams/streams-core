import { suite, test } from '@testdeck/mocha';
import { TestCase } from '../TestCase';
import { Criteria, Stream } from '@/Streams';
import { mock } from 'sinon';
import f from 'faker';
import { LocalStorageAdapter, Transformer } from '@';
import { expect } from 'chai';


@suite()
class StorageTest extends TestCase{

    @test 'storing/retreiving simple data types'(){
        let storage = new LocalStorageAdapter()
        let date = new Date(Date.now())
        storage.set('a-bool',true)
        storage.set('a-number',123.32)
        storage.set('a-string','asf')
        storage.set('a-regexp',/^hello$/)
        storage.set('a-date',date)
        storage.has('a-bool').should.eq(true)
        storage.has('a-number').should.eq(true)
        storage.has('a-string').should.eq(true)
        storage.has('a-regexp').should.eq(true);
        storage.has('a-date').should.eq(true);
        storage.get('a-bool').should.eq(true)
        storage.get('a-number').should.eq(123.32)
        storage.get('a-string').should.eq('asf')
        let regexp = storage.get<RegExp>('a-regexp');
        regexp.should.be.an.instanceof(RegExp);
        regexp.test('no').should.eq(false)
        regexp.test('hello').should.eq(true)
        storage.get<Date>('a-date').getTime().should.eq(date.getTime())
    }

    @test 'storing/retreiving big object'(){
        let storage = new LocalStorageAdapter()
        let obj = require('../_support/package-lock-data.json');
        storage.set('a-obj',obj)
        storage.has('a-obj').should.eq(true)
        storage.get('a-obj').should.deep.eq(obj)
    }

    @test 'storing/retreiving small object'(){
        let storage = new LocalStorageAdapter()
        const obj = require('../_support/data.json');
        storage.set('a-obj',obj)
        storage.has('a-obj').should.eq(true)
        storage.get('a-obj').should.deep.eq(obj)
    }

    @test 'storing should emit event'(done){
        let storage = new LocalStorageAdapter()
        storage.on('set:foo', (value) => {
            value.should.eq('bar');
            done()
        })
        storage.set('foo','bar')
    }
    @test 'event names can accept wildcard'(done){
        let storage = new LocalStorageAdapter()
        let sets = 2;
        storage.on('set:*', (value,key) => {
            expect(['foo','benny']).include(key)
            value.should.eq('bar');
            sets--;
            if(sets === 0) done()
        })
        storage.set('foo','bar')
        storage.set('benny','bar')
    }
}
