document.addEventListener('DOMContentLoaded', () => {
    const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    const siteHeader = document.querySelector('.site-header');
    const scrollProgress = document.querySelector('[data-scroll-progress]');
    const heroSlidesContainer = document.querySelector('.hero-slides');
    let scrollFrameScheduled = false;
    let headerIsScrolled = false;

    const updateScrollEffects = () => {
        if (scrollFrameScheduled) {
            return;
        }

        scrollFrameScheduled = true;

        window.requestAnimationFrame(() => {
            const isScrolled = window.scrollY > 24;

            if (siteHeader && isScrolled !== headerIsScrolled) {
                siteHeader.classList.toggle('is-scrolled', isScrolled);
                headerIsScrolled = isScrolled;
            }

            if (scrollProgress) {
                const scrollableHeight = document.documentElement.scrollHeight - window.innerHeight;
                const progress = scrollableHeight > 0
                    ? Math.min(Math.max(window.scrollY / scrollableHeight, 0), 1)
                    : 0;

                scrollProgress.style.transform = `scaleX(${progress})`;
            }

            if (heroSlidesContainer && !prefersReducedMotion) {
                const parallaxOffset = -Math.min(Math.max(window.scrollY, 0) * 0.06, 20);

                heroSlidesContainer.style.setProperty('--hero-parallax', `${parallaxOffset}px`);
            }

            scrollFrameScheduled = false;
        });
    };

    updateScrollEffects();
    window.addEventListener('scroll', updateScrollEffects, { passive: true });
    window.addEventListener('resize', updateScrollEffects);

    const revealSelector = [
        '.home-hero-copy',
        '.section-heading',
        '.indicator-intro',
        '.indicator-card',
        '.product-tile',
        '.advantage-item',
        '.why-copy',
        '.why-image',
        '.page-hero h1',
        '.value-item',
        '.history-layout > *',
        '.team-card',
        '.activity-card',
        '.sustainability-copy',
        '.exhibition-grid img',
        '.facility-card',
        '.capacity-feature-copy',
        '.capacity-feature > img',
        '.capacity-card',
        '.certification-layout > *',
        '.certificate-card',
        '.workshop-card',
        '.catalog-heading',
        '.catalog-tabs',
        '.catalog-item',
        '.contact-intro',
        '.contact-methods article',
        '.contact-map-section',
        '.contact-form-section',
        '.contact-form-heading',
        '.contact-form-card',
        '.contact-aside-card',
        '.partner-cta-inner > *',
        '.news-section',
    ].join(',');
    const revealTargets = [...document.querySelectorAll(revealSelector)];

    if (
        revealTargets.length > 0
        && !prefersReducedMotion
        && 'IntersectionObserver' in window
    ) {
        const revealIndexes = new Map();
        const revealObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.12, rootMargin: '0px 0px -24px 0px' });

        revealTargets.forEach((target) => {
            const parent = target.parentElement;
            const index = revealIndexes.get(parent) || 0;
            revealIndexes.set(parent, index + 1);
            target.classList.add('scroll-reveal');
            target.style.setProperty('--reveal-delay', `${Math.min(index, 4) * 70}ms`);
            revealObserver.observe(target);
        });
    }

    const countUpTargets = [...document.querySelectorAll('[data-count-up]')];

    if (countUpTargets.length > 0 && !prefersReducedMotion && 'IntersectionObserver' in window) {
        const counterObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach((entry) => {
                if (!entry.isIntersecting) {
                    return;
                }

                const counter = entry.target;
                const finalText = counter.textContent.trim();
                const numberMatch = finalText.match(/^(.*?)(\d+(?:[,\s\u00a0\u202f]+\d+)*)(.*)$/);

                if (!numberMatch) {
                    throw new Error('Count-up value must contain a formatted number.');
                }

                const prefix = numberMatch[1];
                const targetValue = Number(numberMatch[2].replace(/\D/g, ''));

                if (!Number.isSafeInteger(targetValue)) {
                    throw new Error('Count-up value must be a safe integer.');
                }

                const suffix = numberMatch[3];
                const formatterLocale = document.documentElement.lang === 'ru'
                    ? 'ru-RU'
                    : (document.documentElement.lang === 'uz' ? 'uz-UZ' : 'en-US');
                const formatter = new Intl.NumberFormat(formatterLocale, {
                    useGrouping: !counter.hasAttribute('data-count-up-plain'),
                });
                const startedAt = performance.now();

                const animateCounter = (currentTime) => {
                    const progress = Math.min((currentTime - startedAt) / 1400, 1);
                    const easedProgress = 1 - Math.pow(1 - progress, 3);

                    counter.textContent = `${prefix}${formatter.format(Math.round(targetValue * easedProgress))}${suffix}`;

                    if (progress < 1) {
                        window.requestAnimationFrame(animateCounter);
                    } else {
                        counter.textContent = finalText;
                    }
                };

                observer.unobserve(counter);
                window.requestAnimationFrame(animateCounter);
            });
        }, { threshold: 0.6 });

        countUpTargets.forEach((counter) => counterObserver.observe(counter));
    }

    const menuToggle = document.querySelector('[data-menu-toggle]');
    const mobileMenu = document.querySelector('[data-mobile-menu]');
    const menuClose = document.querySelector('[data-menu-close]');

    if (menuToggle && mobileMenu) {
        const setMenuOpen = (isOpen) => {
            mobileMenu.hidden = !isOpen;
            menuToggle.setAttribute('aria-expanded', String(isOpen));
            document.body.classList.toggle('menu-open', isOpen);
        };

        menuToggle.addEventListener('click', () => {
            setMenuOpen(menuToggle.getAttribute('aria-expanded') !== 'true');
        });
        menuClose?.addEventListener('click', () => setMenuOpen(false));
        mobileMenu.querySelectorAll('a').forEach((link) => {
            link.addEventListener('click', () => setMenuOpen(false));
        });
        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape') {
                setMenuOpen(false);
            }
        });
    }

    const heroSlides = [...document.querySelectorAll('[data-hero-slide]')];
    const heroDots = [...document.querySelectorAll('[data-hero-dot]')];
    let activeHeroSlide = 0;

    const showHeroSlide = (index) => {
        if (heroSlides.length === 0) {
            return;
        }

        activeHeroSlide = index % heroSlides.length;
        heroSlides.forEach((slide, slideIndex) => {
            slide.classList.toggle('is-active', slideIndex === activeHeroSlide);
        });
        heroDots.forEach((dot, dotIndex) => {
            dot.classList.toggle('is-active', dotIndex === activeHeroSlide);
        });
    };

    heroDots.forEach((dot) => {
        dot.addEventListener('click', () => showHeroSlide(Number(dot.dataset.heroDot)));
    });

    if (heroSlides.length > 1) {
        window.setInterval(() => showHeroSlide(activeHeroSlide + 1), 6500);
    }

    const videoOpenButton = document.querySelector('[data-video-open]');

    if (videoOpenButton) {
        const videoDialog = document.querySelector('[data-video-dialog]');
        const videoFrame = videoDialog?.querySelector('[data-video-frame]');
        const videoCloseButton = videoDialog?.querySelector('[data-video-close]');

        if (
            !(videoDialog instanceof HTMLDialogElement)
            || !(videoFrame instanceof HTMLIFrameElement)
            || !videoCloseButton
        ) {
            throw new Error('Home video dialog is missing required elements.');
        }

        videoOpenButton.addEventListener('click', () => {
            videoFrame.src = videoOpenButton.dataset.videoSrc || 'about:blank';
            videoDialog.showModal();
        });

        videoCloseButton.addEventListener('click', () => videoDialog.close());
        videoDialog.addEventListener('click', (event) => {
            if (event.target === videoDialog) {
                videoDialog.close();
            }
        });
        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape' && videoDialog.open) {
                event.preventDefault();
                videoDialog.close();
            }
        });
        videoDialog.addEventListener('close', () => {
            videoFrame.src = 'about:blank';
        });
    }

    const productCategoryButtons = [...document.querySelectorAll('[data-product-category]')];
    const productGalleries = [...document.querySelectorAll('[data-product-gallery]')];

    productCategoryButtons.forEach((button) => {
        button.addEventListener('click', () => {
            const selectedGallery = button.dataset.productCategory;

            productCategoryButtons.forEach((categoryButton) => {
                const isSelected = categoryButton === button;
                categoryButton.classList.toggle('is-active', isSelected);
                categoryButton.setAttribute('aria-selected', String(isSelected));
            });

            productGalleries.forEach((gallery) => {
                gallery.hidden = gallery.dataset.productGallery !== selectedGallery;
            });
        });
    });

    const imageViewer = document.querySelector('[data-image-viewer]');
    const viewerImage = document.querySelector('[data-image-viewer-image]');

    document.querySelectorAll('[data-catalog-image]').forEach((item) => {
        item.addEventListener('click', () => {
            if (!imageViewer || !viewerImage) {
                return;
            }

            viewerImage.src = item.dataset.catalogImage;
            viewerImage.alt = item.querySelector('img')?.alt || '';
            imageViewer.hidden = false;
            document.body.classList.add('menu-open');
        });
    });

    document.querySelectorAll('[data-image-viewer-close]').forEach((button) => {
        button.addEventListener('click', () => {
            if (imageViewer) {
                imageViewer.hidden = true;
                document.body.classList.remove('menu-open');
            }
        });
    });

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape' && imageViewer && !imageViewer.hidden) {
            imageViewer.hidden = true;
            document.body.classList.remove('menu-open');
        }
    });

    const contactForm = document.querySelector('[data-contact-form]');
    const captchaQuestion = document.querySelector('[data-captcha-question]');
    const captchaInput = contactForm?.querySelector('[name="captcha"]');
    let captchaAnswer = 0;

    const refreshCaptcha = () => {
        const firstNumber = Math.floor(Math.random() * 8) + 1;
        const secondNumber = Math.floor(Math.random() * 8) + 1;
        captchaAnswer = firstNumber + secondNumber;

        if (captchaQuestion) {
            captchaQuestion.textContent = `${firstNumber} + ${secondNumber} =`;
        }
    };

    document.querySelector('[data-captcha-refresh]')?.addEventListener('click', refreshCaptcha);

    if (contactForm && captchaQuestion && captchaInput) {
        refreshCaptcha();

        contactForm.addEventListener('submit', (event) => {
            event.preventDefault();

            const errorMessage = contactForm.querySelector('[data-form-error]');
            const successMessage = contactForm.querySelector('[data-form-note]');

            if (errorMessage) {
                errorMessage.hidden = true;
            }

            if (successMessage) {
                successMessage.hidden = true;
            }

            if (Number(captchaInput.value) !== captchaAnswer) {
                if (errorMessage) {
                    errorMessage.textContent = document.documentElement.lang === 'en'
                        ? 'The answer is incorrect. Please try again.'
                        : (document.documentElement.lang === 'uz'
                            ? 'Javob noto‘g‘ri. Qayta urinib ko‘ring.'
                            : 'Неверный ответ. Попробуйте ещё раз.');
                    errorMessage.hidden = false;
                }

                refreshCaptcha();
                captchaInput.value = '';
                captchaInput.focus();

                return;
            }

            contactForm.submit();
        });
    }

    const assistant = document.querySelector('[data-site-assistant]');
    const assistantToggle = assistant?.querySelector('[data-assistant-toggle]');
    const assistantPanel = assistant?.querySelector('[data-assistant-panel]');
    const assistantClose = assistant?.querySelector('[data-assistant-close]');
    const assistantForm = assistant?.querySelector('[data-assistant-form]');
    const assistantMessages = assistant?.querySelector('[data-assistant-messages]');
    const assistantSuggestions = assistant?.querySelector('[data-assistant-suggestions]');
    const assistantInput = assistantForm?.querySelector('[name="question"]');

    const setAssistantOpen = (isOpen) => {
        if (!assistantPanel || !assistantToggle) {
            return;
        }

        assistantPanel.hidden = !isOpen;
        assistantToggle.setAttribute('aria-expanded', String(isOpen));

        if (isOpen) {
            assistantInput?.focus();
            assistantMessages?.scrollTo({ top: assistantMessages.scrollHeight, behavior: 'smooth' });
        }
    };

    const appendAssistantMessage = (text, isBot = false, actions = []) => {
        if (!assistantMessages) {
            return;
        }

        const message = document.createElement('div');
        message.className = `assistant-message ${isBot ? 'is-bot' : 'is-user'}`;
        const messageText = document.createElement('p');
        messageText.textContent = text;
        message.append(messageText);

        if (isBot && actions.length > 0) {
            const actionList = document.createElement('div');
            actionList.className = 'assistant-actions';

            actions.forEach((action) => {
                if (!action || typeof action.label !== 'string' || typeof action.url !== 'string') {
                    return;
                }

                const actionLink = document.createElement('a');
                actionLink.href = action.url;
                actionLink.textContent = action.label;
                actionLink.append(' ↗');
                actionList.append(actionLink);
            });

            message.append(actionList);
        }

        assistantMessages.append(message);
        assistantMessages.scrollTo({ top: assistantMessages.scrollHeight, behavior: 'smooth' });
    };

    assistantToggle?.addEventListener('click', () => {
        setAssistantOpen(assistantPanel?.hidden ?? false);
    });
    assistantClose?.addEventListener('click', () => setAssistantOpen(false));
    assistantSuggestions?.querySelectorAll('[data-assistant-question]').forEach((button) => {
        button.addEventListener('click', () => {
            if (assistantInput) {
                assistantInput.value = button.dataset.assistantQuestion || '';
                assistantForm?.requestSubmit();
            }
        });
    });

    assistantForm?.addEventListener('submit', async (event) => {
        event.preventDefault();

        const question = assistantInput?.value.trim();
        const endpoint = assistant?.dataset.endpoint;
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        const submitButton = assistantForm.querySelector('button[type="submit"]');

        if (!question || !endpoint || !csrfToken || !submitButton) {
            return;
        }

        appendAssistantMessage(question);
        assistantInput.value = '';
        submitButton.disabled = true;
        assistantSuggestions?.setAttribute('hidden', '');

        try {
            const response = await fetch(endpoint, {
                method: 'POST',
                credentials: 'same-origin',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                },
                body: JSON.stringify({
                    question,
                    website: assistantForm.querySelector('[name="website"]')?.value || '',
                }),
            });
            const payload = await response.json();

            if (!response.ok) {
                throw new Error(payload.message || Object.values(payload.errors || {}).flat()[0] || 'Assistant request failed.');
            }

            appendAssistantMessage(payload.answer, true, payload.actions || []);
        } catch (error) {
            appendAssistantMessage(error instanceof Error
                ? error.message
                : (document.documentElement.lang === 'en'
                    ? 'The assistant could not send a response.'
                    : (document.documentElement.lang === 'uz'
                        ? 'Yordamchi javob yubora olmadi.'
                        : 'Помощник не смог отправить ответ.')), true);
        } finally {
            submitButton.disabled = false;
            assistantInput.focus();
        }
    });
});
