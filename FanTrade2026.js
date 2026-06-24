const API_BASE = 'backend/';

// Load products on page load
document.addEventListener('DOMContentLoaded', () => {
    loadProducts();
    setupEventListeners();
});

// Setup form event listeners
function setupEventListeners() {
    document.getElementById('registerForm').addEventListener('submit', handleRegister);
    document.getElementById('loginForm').addEventListener('submit', handleLogin);
    document.getElementById('productForm').addEventListener('submit', handleAddProduct);
}

// Registration Handler
async function handleRegister(e) {
    e.preventDefault();
    
    const name = document.getElementById('reg_name').value;
    const email = document.getElementById('reg_email').value;
    const password = document.getElementById('reg_password').value;
    const msgDiv = document.getElementById('registerMsg');

    // Validation
    if (!name || !email || !password) {
        showMessage(msgDiv, 'All fields are required', 'error');
        return;
    }

    try {
        const response = await fetch(API_BASE + 'register.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: `name=${encodeURIComponent(name)}&email=${encodeURIComponent(email)}&password=${encodeURIComponent(password)}`
        });

        const text = await response.text();
        if (text.includes('success')) {
            showMessage(msgDiv, 'Registration Successful! Please log in.', 'success');
            document.getElementById('registerForm').reset();
        } else {
            showMessage(msgDiv, text, 'error');
        }
    } catch (error) {
        showMessage(msgDiv, 'Error: ' + error.message, 'error');
    }
}

// Login Handler
async function handleLogin(e) {
    e.preventDefault();
    
    const email = document.getElementById('login_email').value;
    const password = document.getElementById('login_password').value;
    const msgDiv = document.getElementById('loginMsg');

    // Validation
    if (!email || !password) {
        showMessage(msgDiv, 'All fields are required', 'error');
        return;
    }

    try {
        const response = await fetch(API_BASE + 'login.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: `email=${encodeURIComponent(email)}&password=${encodeURIComponent(password)}`
        });

        const text = await response.text();
        if (text.includes('success')) {
            showMessage(msgDiv, 'Login Successful! Redirecting...', 'success');
            localStorage.setItem('userEmail', email);
            setTimeout(() => {
                window.location.href = 'index.php';
            }, 1500);
        } else {
            showMessage(msgDiv, 'Invalid Login Credentials', 'error');
        }
    } catch (error) {
        showMessage(msgDiv, 'Error: ' + error.message, 'error');
    }
}

// Add Product Handler
async function handleAddProduct(e) {
    e.preventDefault();
    
    const productName = document.getElementById('product_name').value;
    const price = document.getElementById('price').value;
    const description = document.getElementById('description').value;
    const msgDiv = document.getElementById('productMsg');

    // Validation
    if (!productName || !price || !description) {
        showMessage(msgDiv, 'All fields are required', 'error');
        return;
    }

    try {
        const response = await fetch(API_BASE + 'products.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: `action=add&product_name=${encodeURIComponent(productName)}&price=${encodeURIComponent(price)}&description=${encodeURIComponent(description)}`
        });

        const text = await response.text();
        if (text.includes('success')) {
            showMessage(msgDiv, 'Product Added Successfully!', 'success');
            document.getElementById('productForm').reset();
            loadProducts();
        } else {
            showMessage(msgDiv, text, 'error');
        }
    } catch (error) {
        showMessage(msgDiv, 'Error: ' + error.message, 'error');
    }
}

// Load and Display Products
async function loadProducts() {
    try {
        const response = await fetch(API_BASE + 'products.php?action=fetch');
        const data = await response.json();
        
        const container = document.getElementById('productsContainer');
        container.innerHTML = '';

        if (data.success && data.products.length > 0) {
            data.products.forEach(product => {
                const productDiv = document.createElement('div');
                productDiv.className = 'product';
                productDiv.innerHTML = `
                    <h3>${escapeHtml(product.product_name)}</h3>
                    <p><strong>Price:</strong> R${escapeHtml(product.price)}</p>
                    <p>${escapeHtml(product.description)}</p>
                    <button onclick="buyProduct(${product.id})">Buy Now</button>
                `;
                container.appendChild(productDiv);
            });
        } else {
            container.innerHTML = '<p>No products available yet.</p>';
        }
    } catch (error) {
        console.error('Error loading products:', error);
        document.getElementById('productsContainer').innerHTML = '<p>Error loading products</p>';
    }
}

// Buy Product Handler
function buyProduct(productId) {
    alert('Buy Now functionality coming soon! Product ID: ' + productId);
}

// Utility: Show Message
function showMessage(element, message, type) {
    element.textContent = message;
    element.className = type;
}

// Utility: Escape HTML to prevent XSS
function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}
