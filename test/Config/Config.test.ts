import { suite, test } from '@testdeck/mocha';
import { TestCase } from '../TestCase';
import { Repository } from '@/Config';

@suite
export class ConfigTest extends TestCase {
    async getConfigData() {
        return (await import('../_support/data.json')).default;
    }

    @test
    async getRepositoryItem() {
        let repo = new Repository(await this.getConfigData());
        repo.get('hash').should.eq('6157fc77301ecc4fb2df2962');
        repo.get('static').should.eq(false);
        repo.get('stuff').should.be.have.property('hash');
    }

    @test
    async testProxy() {
        let repo = Repository.asProxy(await this.getConfigData());
        repo.hash.should.eq('6157fc77301ecc4fb2df2962');
        repo.static.should.eq(false);
        repo.stuff.should.be.have.property('hash');
    }


}
