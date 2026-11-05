/**
 * FAQ Module - Accordion & Filter
 * Dependencies: None (vanilla JS)
 */

(function() {
    'use strict';

    // ============================================
    // DOM REFS
    // ============================================
    const faqList = document.getElementById('faqList');
    const sections = Array.from(document.querySelectorAll('.faq_category_section'));
    const items = Array.from(document.querySelectorAll('.faq_item'));
    const tabs = Array.from(document.querySelectorAll('.cat_btn'));
    const searchInput = document.getElementById('faqSearch');
    const searchBtn = document.getElementById('faqSearchBtn');
    const noResult = document.getElementById('faqNoResult');
    const noResultInitial = document.getElementById('faqNoResultInitial');

    // ============================================
    // INITIALIZE - SETUP AWAL
    // ============================================
    function init() {
        // Sembunyikan semua jawaban
        items.forEach(function(item) {
            const answer = item.querySelector('.faq_answer');
            const icon = item.querySelector('.faq_icon');
            
            if (answer) {
                answer.style.maxHeight = '0';
                answer.style.overflow = 'hidden';
                answer.style.transition = 'max-height 0.4s cubic-bezier(0.34, 1.56, 0.64, 1), padding 0.3s ease';
                answer.setAttribute('aria-hidden', 'true');
            }
            if (icon) {
                icon.style.transform = 'rotate(0deg)';
                icon.style.display = 'inline-block';
                icon.style.transition = 'transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1)';
            }
        });

        // Sembunyikan no result
        if (noResult) noResult.style.display = 'none';
        if (noResultInitial) {
            // Sembunyikan initial jika ada FAQ
            if (items.length > 0) {
                noResultInitial.style.display = 'none';
            }
        }

        // Sembunyikan section "Lainnya" jika kosong
        const lainnyaSection = document.querySelector('.faq_category_section[data-category="lainnya"]');
        if (lainnyaSection) {
            const hasItems = Array.from(lainnyaSection.querySelectorAll('.faq_item')).length > 0;
            if (!hasItems) {
                lainnyaSection.style.display = 'none';
            }
        }

        // Set tab pertama aktif
        const firstTab = document.querySelector('.cat_btn.active') || document.querySelector('.cat_btn');
        if (firstTab) {
            activateTab(firstTab);
        }

        // Auto-open from hash
        if (window.location.hash) {
            setTimeout(function() {
                const target = document.querySelector(window.location.hash);
                if (target && target.classList.contains('faq_item')) {
                    const question = target.querySelector('.faq_question');
                    if (question) {
                        toggleFAQ(question);
                        target.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    }
                }
            }, 500);
        }
    }

    // ============================================
    // TOGGLE FAQ ACCORDION
    // ============================================
    function toggleFAQ(element) {
        const item = element.closest('.faq_item');
        if (!item) return;
        
        const answer = item.querySelector('.faq_answer');
        const icon = element.querySelector('.faq_icon');
        const isActive = item.classList.contains('active');

        // Tutup item lain di section yang sama (opsional, untuk accordion behavior)
        // Uncomment jika ingin hanya satu yang terbuka per section
        // const section = item.closest('.faq_category_section');
        // if (section) {
        //     const otherItems = section.querySelectorAll('.faq_item.active');
        //     otherItems.forEach(function(other) {
        //         if (other !== item) {
        //             const otherAnswer = other.querySelector('.faq_answer');
        //             const otherIcon = other.querySelector('.faq_icon');
        //             other.classList.remove('active');
        //             if (otherAnswer) {
        //                 otherAnswer.style.maxHeight = '0';
        //                 otherAnswer.setAttribute('aria-hidden', 'true');
        //             }
        //             if (otherIcon) otherIcon.style.transform = 'rotate(0deg)';
        //         }
        //     });
        // }

        if (isActive) {
            // CLOSE
            item.classList.remove('active');
            if (icon) icon.style.transform = 'rotate(0deg)';
            if (answer) {
                answer.style.maxHeight = '0';
                answer.setAttribute('aria-hidden', 'true');
            }
        } else {
            // OPEN
            item.classList.add('active');
            if (icon) icon.style.transform = 'rotate(180deg)';
            if (answer) {
                // Force reflow
                void answer.offsetWidth;
                answer.style.maxHeight = answer.scrollHeight + 'px';
                answer.setAttribute('aria-hidden', 'false');
            }
        }
    }

    // ============================================
    // ACTIVATE TAB
    // ============================================
    function activateTab(tab) {
        const category = tab.dataset.category;
        
        // Update active class
        tabs.forEach(function(t) {
            const isActive = t === tab;
            t.classList.toggle('active', isActive);
            t.setAttribute('aria-selected', isActive ? 'true' : 'false');
            t.setAttribute('tabindex', isActive ? '0' : '-1');
        });

        // Tampilkan/sembunyikan section
        sections.forEach(function(s) {
            if (category === 'all') {
                s.style.display = 'block';
            } else {
                s.style.display = (s.dataset.category === category) ? 'block' : 'none';
            }
        });

        // Reset search dan tampilkan semua item
        if (searchInput) {
            searchInput.value = '';
        }
        items.forEach(function(i) {
            i.style.display = 'block';
        });
        
        checkNoResult();
    }

    // ============================================
    // FILTER SEARCH
    // ============================================
    function filterFAQs() {
        const query = searchInput.value.toLowerCase().trim();
        
        // Reset semua tampilan
        items.forEach(function(i) {
            i.style.display = 'block';
        });
        sections.forEach(function(s) {
            s.style.display = 'block';
        });

        // Jika kosong, set tab Semua
        if (query === '') {
            const allTab = document.querySelector('.cat_btn[data-category="all"]');
            if (allTab) {
                activateTab(allTab);
            }
            return;
        }

        // Filter berdasarkan query
        let hasVisible = false;
        items.forEach(function(item) {
            const question = item.dataset.question || '';
            const answer = item.dataset.answer || '';
            const match = question.includes(query) || answer.includes(query);
            item.style.display = match ? 'block' : 'none';
            if (match) hasVisible = true;
        });

        // Sembunyikan section yang kosong
        sections.forEach(function(section) {
            const sectionItems = Array.from(section.querySelectorAll('.faq_item'));
            const hasVisibleItems = sectionItems.some(function(si) {
                return window.getComputedStyle(si).display !== 'none';
            });
            section.style.display = hasVisibleItems ? 'block' : 'none';
        });

        // Update no result
        if (noResult) {
            noResult.style.display = hasVisible ? 'none' : 'flex';
        }

        // Set active tab ke Semua
        tabs.forEach(function(t) {
            t.classList.remove('active');
            t.setAttribute('aria-selected', 'false');
        });
        const allTab = document.querySelector('.cat_btn[data-category="all"]');
        if (allTab) {
            allTab.classList.add('active');
            allTab.setAttribute('aria-selected', 'true');
        }
    }

    // ============================================
    // CHECK NO RESULT
    // ============================================
    function checkNoResult() {
        if (!noResult) return;
        const anyVisible = items.some(function(i) {
            return window.getComputedStyle(i).display !== 'none';
        });
        noResult.style.display = anyVisible ? 'none' : 'flex';
    }

    // ============================================
    // EVENT LISTENERS
    // ============================================
    
    // Click pada question -> toggle
    faqList.addEventListener('click', function(e) {
        const question = e.target.closest('.faq_question');
        if (question) {
            e.preventDefault();
            toggleFAQ(question);
        }
    });

    // Keyboard support (Enter/Space)
    faqList.addEventListener('keydown', function(e) {
        const question = e.target.closest('.faq_question');
        if (!question) return;
        if (e.key === 'Enter' || e.key === ' ') {
            e.preventDefault();
            toggleFAQ(question);
        }
    });

    // Tab click
    tabs.forEach(function(tab) {
        tab.addEventListener('click', function(e) {
            e.preventDefault();
            activateTab(tab);
        });
    });

    // Keyboard navigation tabs (arrow keys)
    const tablist = document.querySelector('.faq_categories');
    if (tablist) {
        tablist.addEventListener('keydown', function(e) {
            const current = document.activeElement;
            if (!current || !current.classList.contains('cat_btn')) return;
            
            const tabsArray = Array.from(tabs);
            const idx = tabsArray.indexOf(current);
            let newIdx = idx;
            
            if (e.key === 'ArrowRight' || e.key === 'ArrowDown') {
                e.preventDefault();
                newIdx = (idx + 1) % tabsArray.length;
            } else if (e.key === 'ArrowLeft' || e.key === 'ArrowUp') {
                e.preventDefault();
                newIdx = (idx - 1 + tabsArray.length) % tabsArray.length;
            }
            
            if (newIdx !== idx) {
                tabsArray[newIdx].focus();
                activateTab(tabsArray[newIdx]);
            }
        });
    }

    // Search input (debounced)
    let searchTimeout;
    searchInput.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(filterFAQs, 150);
    });

    searchBtn.addEventListener('click', filterFAQs);

    // ============================================
    // RUN INIT
    // ============================================
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }

    console.log('FAQ initialized with', items.length, 'items');

})();