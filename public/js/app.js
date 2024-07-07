document.querySelector('.btn-view-all').addEventListener('click', function(e) {
    e.preventDefault();
    const productsContainer = document.getElementById('products-container');
    productsContainer.scrollIntoView({ behavior: 'smooth' });
});
