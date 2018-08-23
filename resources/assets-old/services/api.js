/**
 * @var {Object}
 */
export const getHeaders = () => ({
  'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
  'X-Requested-With': 'XMLHttpRequest',
})