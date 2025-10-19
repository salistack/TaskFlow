import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

const themeStore = {
	dark: document.documentElement.classList.contains('dark'),
	init() {
		this.sync();

		const mediaQuery = window.matchMedia('(prefers-color-scheme: dark)');

		if (mediaQuery.addEventListener) {
			mediaQuery.addEventListener('change', (event) => {
				if (!localStorage.getItem('theme')) {
					this.set(event.matches, false);
				}
			});
		} else if (mediaQuery.addListener) {
			mediaQuery.addListener((event) => {
				if (!localStorage.getItem('theme')) {
					this.set(event.matches, false);
				}
			});
		}

		window.addEventListener('storage', (event) => {
			if (event.key === 'theme') {
				this.set(event.newValue === 'dark', false);
			}
		});
	},
	toggle() {
		this.set(!this.dark);
	},
	set(value, persist = true) {
		this.dark = value;
		document.documentElement.classList.toggle('dark', value);
		document.documentElement.style.colorScheme = value ? 'dark' : 'light';

		if (persist) {
			localStorage.setItem('theme', value ? 'dark' : 'light');
		}
	},
	sync() {
		const stored = localStorage.getItem('theme');

		if (stored === 'dark' || stored === 'light') {
			this.set(stored === 'dark', false);
		} else {
			this.set(window.matchMedia('(prefers-color-scheme: dark)').matches, false);
		}
	},
};

Alpine.store('theme', themeStore);

Alpine.start();

themeStore.init();
