import type { Config } from 'tailwindcss'

const config: Config = {
  content: [
    './app.vue',
    './nuxt.config.{js,ts}',
    './components/**/*.{vue,js,ts,jsx,tsx}',import type { Config } from 'tailwindcss'

    const config: Config = {
      content: [
        './app.vue',
        './nuxt.config.{js,ts}',
        './components/**/*.{vue,js,ts,jsx,tsx}',
        './layouts/**/*.{vue,js,ts,jsx,tsx}',
        './pages/**/*.{vue,js,ts,jsx,tsx}',
        './plugins/**/*.{js,ts}',
        './composables/**/*.{js,ts}',
        './assets/css/**/*.{css,scss,sass,less}'
      ],
      theme: {
        extend: {
          colors: {
            border: 'var(--color-border)',
            ring: 'var(--color-ring)',
            background: 'var(--color-background)',
            foreground: 'var(--color-foreground)',
            card: 'var(--color-card)',
            'card-foreground': 'var(--color-card-foreground)',
            popover: 'var(--color-popover)',
            'popover-foreground': 'var(--color-popover-foreground)',
            primary: 'var(--color-primary)',
            'primary-foreground': 'var(--color-primary-foreground)',
            secondary: 'var(--color-secondary)',
            'secondary-foreground': 'var(--color-secondary-foreground)',
            muted: 'var(--color-muted)',
            'muted-foreground': 'var(--color-muted-foreground)',
            accent: 'var(--color-accent)',
            'accent-foreground': 'var(--color-accent-foreground)',
            destructive: 'var(--color-destructive)',
            'destructive-foreground': 'var(--color-destructive-foreground)'
          }
        }
      },
      plugins: []
    }
    
    export default config
    
    './layouts/**/*.{vue,js,ts,jsx,tsx}',
    './pages/**/*.{vue,js,ts,jsx,tsx}',
    './plugins/**/*.{js,ts}',
    './composables/**/*.{js,ts}',
    './assets/css/**/*.{css,scss,sass,less}'
  ],
  theme: {
    extend: {
      colors: {
        border: 'var(--color-border)',
        ring: 'var(--color-ring)',
        background: 'var(--color-background)',
        foreground: 'var(--color-foreground)',
        card: 'var(--color-card)',
        'card-foreground': 'var(--color-card-foreground)',
        popover: 'var(--color-popover)',
        'popover-foreground': 'var(--color-popover-foreground)',
        primary: 'var(--color-primary)',
        'primary-foreground': 'var(--color-primary-foreground)',
        secondary: 'var(--color-secondary)',
        'secondary-foreground': 'var(--color-secondary-foreground)',
        muted: 'var(--color-muted)',
        'muted-foreground': 'var(--color-muted-foreground)',
        accent: 'var(--color-accent)',
        'accent-foreground': 'var(--color-accent-foreground)',
        destructive: 'var(--color-destructive)',
        'destructive-foreground': 'var(--color-destructive-foreground)'
      }
    }
  },
  plugins: []
}

export default config
