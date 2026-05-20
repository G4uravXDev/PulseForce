<style>
    /* Page Transition Loader */
    #page-transition-loader {
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        background-color: #1c1c1e; /* dark charcoal */
        z-index: 999999;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        opacity: 1;
        visibility: visible;
        transition: opacity 0.4s cubic-bezier(0.4, 0, 0.2, 1), visibility 0.4s ease;
    }

    #page-transition-loader.loaded {
        opacity: 0;
        visibility: hidden;
    }

    .pulse-brand {
        color: #f0ebe2; /* cream */
        font-family: 'Syne', sans-serif;
        font-weight: 800;
        font-size: 1.5rem;
        margin-bottom: 1rem;
        letter-spacing: -0.02em;
    }
    
    .pulse-brand span {
        color: #c94f2c; /* rust */
    }

    /* Simple sleek spinner */
    .pulse-spinner {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        border: 2px solid rgba(201, 79, 44, 0.2); 
        border-top-color: #c94f2c;
        animation: loader-spin 0.8s infinite linear;
    }

    @keyframes loader-spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
</style>

<div id="page-transition-loader">
    <div class="pulse-brand">Pulse<span>Force</span></div>
    <div class="pulse-spinner"></div>
</div>

<script>
    // Fade out loader when page is fully loaded
    window.addEventListener('load', function() {
        const loader = document.getElementById('page-transition-loader');
        if (loader) {
            loader.classList.add('loaded');
        }
    });

    // Fade in loader before leaving the page (clicking a link)
    document.addEventListener('DOMContentLoaded', function() {
        const links = document.querySelectorAll('a[href]:not([target="_blank"]):not([href^="#"]):not([href^="javascript:"])');
        
        links.forEach(link => {
            link.addEventListener('click', function(e) {
                // Ignore if opening in new tab via ctrl/cmd click or if it's a download link
                if (e.ctrlKey || e.metaKey || e.shiftKey || link.hasAttribute('download')) return;
                
                // Skip file downloads (CSV export, report download, etc.)
                const href = link.getAttribute('href') || '';
                if (href.includes('/report/download') || href.includes('/export')) return;

                // Show loader
                const loader = document.getElementById('page-transition-loader');
                if (loader) {
                    loader.classList.remove('loaded');
                    // Safety timeout: auto-hide after 5s in case navigation doesn't happen
                    setTimeout(() => { loader.classList.add('loaded'); }, 5000);
                }
            });
        });
        
        // Handle forms
        const forms = document.querySelectorAll('form:not([target="_blank"])');
        forms.forEach(form => {
            form.addEventListener('submit', function(e) {
                const loader = document.getElementById('page-transition-loader');
                if (loader) {
                    loader.classList.remove('loaded');
                }
            });
        });
    });
    
    // Fallback if load event has already fired
    if (document.readyState === 'complete') {
        const loader = document.getElementById('page-transition-loader');
        if (loader) {
            loader.classList.add('loaded');
        }
    }
    
    // In case user presses back button (bfcache), we need to hide the loader again
    window.addEventListener('pageshow', function(event) {
        if (event.persisted) {
            const loader = document.getElementById('page-transition-loader');
            if (loader) {
                loader.classList.add('loaded');
            }
        }
    });
</script>
