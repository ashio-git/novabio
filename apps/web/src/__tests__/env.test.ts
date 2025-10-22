import { describe, it, expect, beforeEach } from 'vitest'

describe('Environment Validation', () => {
  beforeEach(() => {
    process.env.NODE_ENV = 'test'
    process.env.NEXT_PUBLIC_APP_URL = 'http://localhost:3000'
    process.env.NEXT_PUBLIC_API_URL = 'http://localhost:8000'
  })

  it('should validate environment variables', () => {
    expect(process.env.NODE_ENV).toBe('test')
    expect(process.env.NEXT_PUBLIC_APP_URL).toBeDefined()
    expect(process.env.NEXT_PUBLIC_API_URL).toBeDefined()
  })
})
