// Handle adding to cart with AJAX
document.querySelectorAll('.add-to-cart-form').forEach(form => {
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        
        fetch('../cart/add_to_cart.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                alert('Added to cart!');
                document.getElementById('cart-count').textContent = data.count;
            }
        });
    });
});

// Update cart count on page load
document.addEventListener('DOMContentLoaded', function() {
     console.log('Valentine shop JS loaded!');
    fetch('../cart/get_cart_count.php')
        .then(response => response.json())
        .then(data => {
            document.getElementById('cart-count').textContent = data.count;
        });
});

// Add simple animation for Valentine's feel
document.querySelector('h1').addEventListener('click', () => {
  alert('❤️ Welcome to our Valentine Shop! ❤️');
});