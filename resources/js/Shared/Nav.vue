<template>
    <nav class="pt-3">
        <ul>
            <li><Link href="/" class="text-blue" :class="{'font-bold underline': $page.component === 'Home'}">Home</Link></li>
            <li><Link href="/users" class="text-blue" :class="{'font-bold underline': $page.component === 'Users'}">Users</Link></li>
            <li><Link href="/settings" class="text-blue" :class="{'font-bold underline': $page.component === 'Settings'}">Settings</Link></li>
            <li><Link href="/logout" method="post" :data="{foo: 'bar'}" class="text-blue">Logout</Link></li>
        </ul>
    </nav>
</template>

<script>
import { Link } from '@inertiajs/vue3'

export default {
    components: {Link}
}
</script>
