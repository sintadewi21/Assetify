import Alpine from 'alpinejs';

describe('Alpine.js Integration Test', () => {
    test('Alpine should be importable and initialized', () => {
        expect(Alpine).toBeDefined();
        expect(typeof Alpine.start).toBe('function');
    });

    test('Simple addition test to verify Jest runner', () => {
        expect(1 + 2).toBe(3);
    });
});
