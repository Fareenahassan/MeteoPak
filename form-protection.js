/**
 * Universal Form Double Submission Protection
 * Prevents users from submitting forms multiple times by disabling submit buttons
 * and adding visual feedback during submission process.
 */

(function() {
    'use strict';
    
    // Object to track submission states for all forms
    const submissionStates = new Map();
    
    // Configuration options
    const config = {
        submitTimeout: 5000, // Reset button after 5 seconds if no redirect
        loadingText: 'Submitting...',
        loadingIcon: '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>',
        disableOpacity: '0.7'
    };
    
    /**
     * Initialize double submission protection for a form
     */
    function initFormProtection(form) {
        const formId = form.id || `form_${Math.random().toString(36).substr(2, 9)}`;
        const submitButtons = form.querySelectorAll('button[type="submit"], input[type="submit"]');
        
        if (submitButtons.length === 0) return;
        
        // Initialize submission state
        submissionStates.set(formId, false);
        
        // Add event listeners
        form.addEventListener('submit', function(event) {
            handleFormSubmission(event, formId, submitButtons);
        });
        
        form.addEventListener('keydown', function(event) {
            if (event.key === 'Enter' && submissionStates.get(formId)) {
                event.preventDefault();
                return false;
            }
        });
        
        // Store original button states
        submitButtons.forEach(button => {
            button.setAttribute('data-original-text', button.innerHTML);
            button.setAttribute('data-original-disabled', button.disabled);
        });
    }
    
    /**
     * Handle form submission and prevent double submissions
     */
    function handleFormSubmission(event, formId, submitButtons) {
        // Check if already submitting
        if (submissionStates.get(formId)) {
            event.preventDefault();
            return false;
        }
        
        // Set submission state
        submissionStates.set(formId, true);
        
        // Disable all submit buttons and add loading state
        submitButtons.forEach(button => {
            disableSubmitButton(button);
        });
        
        // Set timeout to reset buttons if no redirect occurs
        setTimeout(() => {
            if (submissionStates.get(formId)) {
                resetFormState(formId, submitButtons);
            }
        }, config.submitTimeout);
    }
    
    /**
     * Disable submit button with loading state
     */
    function disableSubmitButton(button) {
        const originalText = button.getAttribute('data-original-text') || button.innerHTML;
        
        button.disabled = true;
        button.style.pointerEvents = 'none';
        button.style.opacity = config.disableOpacity;
        
        // Add loading state based on button type
        if (button.tagName.toLowerCase() === 'button') {
            // For buttons, we can change innerHTML
            button.innerHTML = `${config.loadingIcon} ${config.loadingText}`;
        } else {
            // For input elements, change value
            button.value = config.loadingText;
        }
    }
    
    /**
     * Reset form state and restore original button appearance
     */
    function resetFormState(formId, submitButtons) {
        submissionStates.set(formId, false);
        
        submitButtons.forEach(button => {
            restoreSubmitButton(button);
        });
    }
    
    /**
     * Restore submit button to original state
     */
    function restoreSubmitButton(button) {
        const originalText = button.getAttribute('data-original-text');
        const originalDisabled = button.getAttribute('data-original-disabled') === 'true';
        
        if (originalText) {
            if (button.tagName.toLowerCase() === 'button') {
                button.innerHTML = originalText;
            } else {
                button.value = originalText;
            }
        }
        
        button.disabled = originalDisabled;
        button.style.pointerEvents = '';
        button.style.opacity = '';
    }
    
    /**
     * Public API for manual form state management
     */
    window.FormProtection = {
        /**
         * Reset a specific form's submission state
         */
        resetForm: function(formElement) {
            if (!formElement) return;
            
            const formId = formElement.id || Object.keys(submissionStates).find(id => 
                document.getElementById(id) === formElement
            );
            
            if (formId) {
                const submitButtons = formElement.querySelectorAll('button[type="submit"], input[type="submit"]');
                resetFormState(formId, submitButtons);
            }
        },
        
        /**
         * Check if a form is currently submitting
         */
        isSubmitting: function(formElement) {
            if (!formElement) return false;
            
            const formId = formElement.id || Object.keys(submissionStates).find(id => 
                document.getElementById(id) === formElement
            );
            
            return submissionStates.get(formId) || false;
        },
        
        /**
         * Manually set submission state
         */
        setSubmitting: function(formElement, isSubmitting) {
            if (!formElement) return;
            
            const formId = formElement.id || Object.keys(submissionStates).find(id => 
                document.getElementById(id) === formElement
            );
            
            if (formId) {
                submissionStates.set(formId, isSubmitting);
                const submitButtons = formElement.querySelectorAll('button[type="submit"], input[type="submit"]');
                
                if (isSubmitting) {
                    submitButtons.forEach(button => disableSubmitButton(button));
                } else {
                    submitButtons.forEach(button => restoreSubmitButton(button));
                }
            }
        }
    };
    
    /**
     * Initialize protection when DOM is ready
     */
    function initializeFormProtection() {
        // Find all forms in the document
        const forms = document.querySelectorAll('form');
        
        forms.forEach(form => {
            // Skip forms that already have protection or are marked to skip
            if (form.hasAttribute('data-no-protection') || form.hasAttribute('data-protected')) {
                return;
            }
            
            // Mark as protected
            form.setAttribute('data-protected', 'true');
            
            // Initialize protection
            initFormProtection(form);
        });
    }
    
    // Initialize when DOM is loaded
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initializeFormProtection);
    } else {
        initializeFormProtection();
    }
    
    // Also initialize for dynamically added forms
    if (window.MutationObserver) {
        const observer = new MutationObserver(function(mutations) {
            mutations.forEach(function(mutation) {
                mutation.addedNodes.forEach(function(node) {
                    if (node.nodeType === 1) { // Element node
                        // Check if the added node is a form or contains forms
                        const forms = node.tagName === 'FORM' ? [node] : node.querySelectorAll('form');
                        
                        forms.forEach(form => {
                            if (!form.hasAttribute('data-no-protection') && !form.hasAttribute('data-protected')) {
                                form.setAttribute('data-protected', 'true');
                                initFormProtection(form);
                            }
                        });
                    }
                });
            });
        });
        
        observer.observe(document.body, {
            childList: true,
            subtree: true
        });
    }
    
})(); 