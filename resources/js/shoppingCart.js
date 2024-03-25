class shoppingCart {
    constructor() {
        this.items = this.loadCartFromStorage();
        this.observers = [];
    }

    addObserver = (observer) => {
        this.observers.push(observer);
    }

    removeObserver = (observer) => {
        this.observers = this.observers.filter(o => o !== observer);
    }

    notifyObservers = () => {
        this.observers.forEach(observer => {
            if (typeof observer === 'function') {
                observer(this.items);
            }
        });
        this.saveCartToStorage();
    }

    addItem = (item) => {
        this.items.push(item);
        this.notifyObservers();
    }

    removeItem = (item) => {
        this.items = this.items.filter(i => i !== item);
        this.notifyObservers();
    }

    getItems = () => {
        return this.items;
    }

    saveCartToStorage = () => {
        let itemsWithIds = this.items.map(item => ({
            id: this.generateUniqueId(),
            ...item,
        }));
        localStorage.setItem('funvilla-cart', JSON.stringify(itemsWithIds));
    }

    loadCartFromStorage = () => {
        const storedCart = localStorage.getItem('funvilla-cart');
        return storedCart ? JSON.parse(storedCart) : [];
    }

    generateUniqueId = () => {
        return Math.random().toString(36).substr(2, 9);
    }
}

export default shoppingCart;
