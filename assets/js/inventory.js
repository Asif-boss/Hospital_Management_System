// Basic functionality for the inventory management system
        function exportInventory() {
            alert('Export functionality would be implemented here.');
        }

        function openAddItemModal() {
            document.querySelector('.add-item-form').scrollIntoView({ 
                behavior: 'smooth' 
            });
        }

        function applyInventoryFilters() {
            const category = document.getElementById('categoryFilter').value;
            const stockStatus = document.getElementById('stockFilter').value;
            
            alert(`Filters applied:\nCategory: ${category || 'All'}\nStock Status: ${stockStatus || 'All'}`);
            
            // In a real application, you would filter the inventory items here
        }

        // View toggle functionality
        document.querySelectorAll('.view-btn').forEach(button => {
            button.addEventListener('click', function() {
                document.querySelectorAll('.view-btn').forEach(btn => btn.classList.remove('active'));
                this.classList.add('active');
                
                const view = this.getAttribute('data-view');
                const inventoryGrid = document.getElementById('inventoryGrid');
                
                if (view === 'list') {
                    inventoryGrid.style.gridTemplateColumns = '1fr';
                } else {
                    inventoryGrid.style.gridTemplateColumns = 'repeat(auto-fill, minmax(280px, 1fr))';
                }
            });
        });

        // Search functionality
        document.getElementById('inventorySearch').addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const items = document.querySelectorAll('.inventory-item');
            
            items.forEach(item => {
                const itemName = item.querySelector('h4').textContent.toLowerCase();
                if (itemName.includes(searchTerm)) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
        });