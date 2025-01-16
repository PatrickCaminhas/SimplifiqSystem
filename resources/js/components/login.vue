<template>
    <div>
        Componente Login carregado com sucesso!!!!
        {{ tokencsrf }}

    </div>
    <form method="POST" action="">
        <input type="hidden" name="_token" :value="tokencsrf">

    </form>
</template>

<script>
        export default{
            props: ['tokencsrf']
        }
</script>
